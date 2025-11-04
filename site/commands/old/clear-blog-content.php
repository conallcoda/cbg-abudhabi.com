<?php

$pictures = include __DIR__ . '/pictures.php';

return [
    'description' => 'Nice command',
    'args' => [],
    'command' => static function ($cli) use ($pictures): void {
        kirby()->impersonate('kirby');
        $articles = site()->index(true)->filterBy('template', 'article');
        foreach ($articles as $article) {
            $article->update([
                'text' => null,
                'ps_sections' => null
            ]);
        }
    }
];
