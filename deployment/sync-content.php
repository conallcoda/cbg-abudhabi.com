<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli' || $argc !== 6) {
    fwrite(STDERR, "Usage: sync-content.php BASELINE INCOMING PRODUCTION STATE COMMIT\n");
    exit(2);
}

[, $baselineRoot, $incomingRoot, $productionRoot, $stateRoot, $commit] = $argv;

foreach ([$baselineRoot, $incomingRoot, $productionRoot, $stateRoot] as $root) {
    if (!is_dir($root)) {
        fwrite(STDERR, "Directory does not exist: {$root}\n");
        exit(2);
    }
}


/** @return array<string, array{type: string, signature: string, root: string}> */
function inventory(string $root): array
{
    $result = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($iterator as $file) {
        $absolute = $file->getPathname();
        $relative = str_replace(DIRECTORY_SEPARATOR, '/', substr($absolute, strlen($root) + 1));

        if ($file->isLink()) {
            $target = readlink($absolute);
            $result[$relative] = [
                'type' => 'link',
                'signature' => 'link:' . ($target === false ? '' : $target),
                'root' => $root,
            ];
            continue;
        }

        if (!$file->isFile()) {
            continue;
        }

        $hash = hash_file('sha256', $absolute);
        if ($hash === false) {
            throw new RuntimeException("Could not hash {$absolute}");
        }

        $result[$relative] = [
            'type' => 'file',
            'signature' => 'file:' . $hash,
            'root' => $root,
        ];
    }

    ksort($result);
    return $result;
}

/** @param array{type: string, signature: string, root: string}|null $left
 *  @param array{type: string, signature: string, root: string}|null $right
 */
function entriesEqual(?array $left, ?array $right): bool
{
    return $left === null
        ? $right === null
        : $right !== null && $left['signature'] === $right['signature'];
}

function ensureParentDirectory(string $path): void
{
    $directory = dirname($path);
    if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
        throw new RuntimeException("Could not create directory {$directory}");
    }
}

function removePath(string $path): void
{
    if (is_link($path) || is_file($path)) {
        if (!unlink($path)) {
            throw new RuntimeException("Could not remove {$path}");
        }
    }
}

/** @param array{type: string, signature: string, root: string} $entry */
function copyEntry(array $entry, string $relative, string $destination): void
{
    $source = $entry['root'] . '/' . $relative;
    ensureParentDirectory($destination);

    if ($entry['type'] === 'link') {
        $target = readlink($source);
        if ($target === false || str_starts_with($target, '/') || str_contains($target, '..')) {
            throw new RuntimeException("Unsafe Git symlink: {$relative}");
        }
        removePath($destination);
        if (!symlink($target, $destination)) {
            throw new RuntimeException("Could not create symlink {$destination}");
        }
        return;
    }

    $temporary = tempnam(dirname($destination), '.content-sync-');
    if ($temporary === false) {
        throw new RuntimeException("Could not create a temporary file for {$destination}");
    }

    try {
        if (!copy($source, $temporary)) {
            throw new RuntimeException("Could not copy {$source}");
        }
        chmod($temporary, fileperms($source) & 0777);
        touch($temporary, filemtime($source));
        if (!rename($temporary, $destination)) {
            throw new RuntimeException("Could not replace {$destination}");
        }
    } finally {
        if (is_file($temporary)) {
            unlink($temporary);
        }
    }
}

function removeTree(string $root): void
{
    if (!is_dir($root)) {
        return;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($iterator as $item) {
        $path = $item->getPathname();
        if ($item->isLink() || $item->isFile()) {
            unlink($path);
        } else {
            rmdir($path);
        }
    }
    rmdir($root);
}

function copyTree(string $source, string $destination): void
{
    if (!mkdir($destination, 0775, true) && !is_dir($destination)) {
        throw new RuntimeException("Could not create {$destination}");
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $item) {
        $relative = substr($item->getPathname(), strlen($source) + 1);
        $target = $destination . '/' . $relative;

        if ($item->isLink()) {
            ensureParentDirectory($target);
            $link = readlink($item->getPathname());
            if ($link === false || !symlink($link, $target)) {
                throw new RuntimeException("Could not copy symlink {$relative}");
            }
        } elseif ($item->isDir()) {
            if (!is_dir($target) && !mkdir($target, $item->getPerms() & 0777, true) && !is_dir($target)) {
                throw new RuntimeException("Could not create {$target}");
            }
        } else {
            copyEntry([
                'type' => 'file',
                'signature' => '',
                'root' => $source,
            ], str_replace(DIRECTORY_SEPARATOR, '/', $relative), $target);
        }
    }
}

try {
    $baseline = inventory($baselineRoot);
    $incoming = inventory($incomingRoot);
    $production = inventory($productionRoot);
    $paths = array_unique([...array_keys($baseline), ...array_keys($incoming)]);
    sort($paths);

    $actions = [];
    $conflicts = [];

    foreach ($paths as $path) {
        $old = $baseline[$path] ?? null;
        $new = $incoming[$path] ?? null;

        if (entriesEqual($old, $new)) {
            continue;
        }

        $live = $production[$path] ?? null;
        if (entriesEqual($live, $new)) {
            continue;
        }

        if (entriesEqual($live, $old)) {
            $actions[$path] = $new;
            continue;
        }

        $conflicts[] = $path;
    }

    if ($conflicts !== []) {
        $conflictDirectory = $stateRoot . '/conflicts';
        if (!is_dir($conflictDirectory) && !mkdir($conflictDirectory, 0775, true) && !is_dir($conflictDirectory)) {
            throw new RuntimeException("Could not create {$conflictDirectory}");
        }

        $report = "Content deployment conflict for commit {$commit}\n"
            . "Production and Git both changed these paths since the previous baseline:\n\n"
            . implode("\n", $conflicts) . "\n";
        file_put_contents($conflictDirectory . '/latest.txt', $report);
        fwrite(STDERR, $report);
        fwrite(STDERR, "Production was not modified. Resolve the files locally and deploy again.\n");
        exit(3);
    }

    $backupRoot = $stateRoot . '/backups/' . gmdate('Ymd-His') . '-' . substr($commit, 0, 12) . '/content';
    $applied = 0;

    foreach ($actions as $path => $new) {
        $destination = $productionRoot . '/' . $path;
        $live = $production[$path] ?? null;

        if ($live !== null) {
            copyEntry($live, $path, $backupRoot . '/' . $path);
        }

        if ($new === null) {
            removePath($destination);
            echo "Deleted {$path}\n";
        } else {
            copyEntry($new, $path, $destination);
            echo "Updated {$path}\n";
        }
        $applied++;
    }

    $newBaseline = dirname($baselineRoot) . '/.content-baseline-new-' . getmypid();
    $oldBaseline = dirname($baselineRoot) . '/.content-baseline-old-' . getmypid();
    removeTree($newBaseline);
    removeTree($oldBaseline);
    copyTree($incomingRoot, $newBaseline);

    if (!rename($baselineRoot, $oldBaseline)) {
        throw new RuntimeException('Could not atomically update the content baseline');
    }

    if (!rename($newBaseline, $baselineRoot)) {
        rename($oldBaseline, $baselineRoot);
        throw new RuntimeException('Could not atomically update the content baseline');
    }
    removeTree($oldBaseline);

    $latestConflict = $stateRoot . '/conflicts/latest.txt';
    if (is_file($latestConflict)) {
        unlink($latestConflict);
    }

    echo "Content synchronization complete: {$applied} Git change(s) applied.\n";
} catch (Throwable $exception) {
    fwrite(STDERR, 'Content synchronization failed: ' . $exception->getMessage() . "\n");
    exit(1);
}
