<?php

declare(strict_types=1);

$synchronizer = dirname(__DIR__) . '/sync-content.php';
$root = sys_get_temp_dir() . '/cfc-content-sync-tests-' . getmypid();

function removeFixture(string $path): void
{
    if (!is_dir($path)) {
        return;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($iterator as $item) {
        $item->isDir() && !$item->isLink()
            ? rmdir($item->getPathname())
            : unlink($item->getPathname());
    }
    rmdir($path);
}

/** @param array<string, string> $files */
function writeFixture(string $root, array $files): void
{
    mkdir($root, 0775, true);
    foreach ($files as $path => $contents) {
        $target = $root . '/' . $path;
        if (!is_dir(dirname($target))) {
            mkdir(dirname($target), 0775, true);
        }
        file_put_contents($target, $contents);
    }
}

/**
 * @param array<string, string> $baseline
 * @param array<string, string> $incoming
 * @param array<string, string> $production
 * @return array{code: int, path: string, output: string}
 */
function scenario(
    string $root,
    string $name,
    array $baseline,
    array $incoming,
    array $production,
    string $synchronizer
): array {
    $path = $root . '/' . $name;
    writeFixture($path . '/baseline', $baseline);
    writeFixture($path . '/incoming', $incoming);
    writeFixture($path . '/production', $production);
    writeFixture($path . '/state', []);

    $command = [
        PHP_BINARY,
        $synchronizer,
        $path . '/baseline',
        $path . '/incoming',
        $path . '/production',
        $path . '/state',
        str_repeat('a', 40),
    ];
    $pipes = [];
    $process = proc_open($command, [1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes);
    if (!is_resource($process)) {
        throw new RuntimeException('Could not start content synchronizer');
    }
    $output = stream_get_contents($pipes[1]) . stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);

    return ['code' => proc_close($process), 'path' => $path, 'output' => $output];
}

function assertTest(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

try {
    removeFixture($root);
    mkdir($root, 0775, true);

    $result = scenario($root, 'git-update', ['page.txt' => 'old'], ['page.txt' => 'git'], ['page.txt' => 'old'], $synchronizer);
    assertTest($result['code'] === 0, $result['output']);
    assertTest(file_get_contents($result['path'] . '/production/page.txt') === 'git', 'Git update was not applied');
    assertTest(file_get_contents($result['path'] . '/baseline/page.txt') === 'git', 'Baseline was not advanced');
    $backups = glob($result['path'] . '/state/backups/*/content/page.txt');
    assertTest(count($backups) === 1 && file_get_contents($backups[0]) === 'old', 'Production backup was not created');

    $result = scenario($root, 'production-update', ['page.txt' => 'old'], ['page.txt' => 'old'], ['page.txt' => 'production'], $synchronizer);
    assertTest($result['code'] === 0, $result['output']);
    assertTest(file_get_contents($result['path'] . '/production/page.txt') === 'production', 'Production-only edit was overwritten');

    $result = scenario($root, 'same-update', ['page.txt' => 'old'], ['page.txt' => 'new'], ['page.txt' => 'new'], $synchronizer);
    assertTest($result['code'] === 0, $result['output']);
    assertTest(file_get_contents($result['path'] . '/baseline/page.txt') === 'new', 'Matching changes did not advance baseline');

    $result = scenario($root, 'conflict', ['page.txt' => 'old'], ['page.txt' => 'git'], ['page.txt' => 'production'], $synchronizer);
    assertTest($result['code'] === 3, 'Conflict did not stop deployment');
    assertTest(file_get_contents($result['path'] . '/production/page.txt') === 'production', 'Conflict modified production');
    assertTest(file_get_contents($result['path'] . '/baseline/page.txt') === 'old', 'Conflict advanced baseline');
    assertTest(is_file($result['path'] . '/state/conflicts/latest.txt'), 'Conflict report was not written');

    $result = scenario(
        $root,
        'add-delete',
        ['old.txt' => 'old'],
        ['new.txt' => 'new'],
        ['old.txt' => 'old', 'panel-upload.txt' => 'keep'],
        $synchronizer
    );
    assertTest($result['code'] === 0, $result['output']);
    assertTest(!file_exists($result['path'] . '/production/old.txt'), 'Git deletion was not applied');
    assertTest(file_get_contents($result['path'] . '/production/new.txt') === 'new', 'Git addition was not applied');
    assertTest(file_get_contents($result['path'] . '/production/panel-upload.txt') === 'keep', 'Production addition was removed');

    echo "All content synchronization scenarios passed.\n";
} finally {
    removeFixture($root);
}
