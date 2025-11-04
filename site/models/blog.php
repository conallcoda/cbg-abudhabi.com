<?php

use Kirby\Toolkit\Str;

class BlogPage extends Page
{


    public function _tags()
    {
        $articles = $this->children()->template('article');
        foreach ($articles as $article) {
            foreach ($article->tags()->split(',') as $tag) {
                $normalized = trim(Str::slug($tag));
                if (isset($tags[$normalized])) {
                    $tags[$normalized]['count']++;
                } else {
                    $tags[$normalized] = [
                        'label' => $tag,
                        'value' => $normalized,
                        'count' => 1
                    ];
                }
            }
        }

        $ready = [];
        foreach ($tags as $tag) {
            $ready[] = [
                'label' => sprintf('%s (%d)', $tag['label'], $tag['count']),
                'value' => $tag['value'],
            ];
        }

        return array_values($ready) ?? [];
    }
}
