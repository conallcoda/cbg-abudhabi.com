<?php

return [
    'description' => 'Scaffold templates',
    'args' => [],
    'command' => static function ($cli): void {
        kirby()->impersonate('kirby');
        $site = kirby()->site();
        $tags = [];
        $articles = $site->find('industry-insights')->children()->template('article');

        foreach ($articles as $article) {
            foreach ($article->tags()->split(',') as $tag) {
                $normalized = trim($tag);
                if (isset($tags[$normalized])) {
                    $tags[$normalized]++;
                } else {
                    $tags[$normalized] = 1;
                }
            }
        }

        var_dump($tags);
    }
];
