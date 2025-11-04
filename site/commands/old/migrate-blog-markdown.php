<?php

use Kirby\Toolkit\Str;

$layoutTemplate = include __DIR__ . '/layout_template.php';

return [
    'description' => 'Nice command',
    'args' => [],
    'command' => static function ($cli) use ($layoutTemplate): void {
        kirby()->impersonate('kirby');
        $layoutId = $layoutTemplate[0]['id'];
        $columnId = $layoutTemplate[0]['columns'][0]['id'];
        $blockId = $layoutTemplate[0]['columns'][0]['blocks'][0]['id'];
        $content = $layoutTemplate[0]['columns'][0]['blocks'][0]['content']['text'];

        $base = array_merge([], $layoutTemplate);
        $base[0]['id'] = Str::uuid();
        $base[0]['columns'][0]['id'] = Str::uuid();
        $base[0]['columns'][0]['blocks'][0]['id'] = Str::uuid();

        $articles = site()->index(true)->filterBy('template', 'article');
        foreach ($articles as $article) {
            echo $article->slug() . PHP_EOL;
            $content = $article->text()->value();
            $base[0]['columns'][0]['blocks'][0]['content']['text'] = $content;
            $article->update([
                'layout' => json_encode($base)
            ]);
        }
    }
];
