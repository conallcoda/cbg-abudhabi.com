<?php

$pictures = include __DIR__ . '/pictures.php';

return [
    'description' => 'Nice command',
    'args' => [],
    'command' => static function ($cli) use ($pictures): void {
        kirby()->impersonate('kirby');
        $articles = site()->index(true)->filterBy('template', 'article');
        foreach ($articles as $article) {
            $slug = $article->parent()->slug() . '/' . $article->slug();
            if ($article->picture()->isEmpty()) {
                if (isset($pictures[$slug])) {
                    $file = $article->files()->find($pictures[$slug]);
                    if ($file) {
                        echo $slug;
                        $article->update([
                            'picture' => '- ' . (string)$file->uuid()
                        ]);
                    } else {
                        echo 1;
                    }
                }
            }
        }

        die;
        foreach ($pictures as $slug => $fileId) {
            $page = site()->find($slug);
            if (!$page) {
                continue;
            }
            $file = $page->files()->find($fileId);
            if (!$file) {
                echo $slug . ': ' . $fileId . PHP_EOL;
            }
        }
        die;
    }
];
