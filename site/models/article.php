<?php

use CFC\Model\HasAccess;
use Kirby\Cms\Collection;
use Kirby\Toolkit\Str;
use CFC\Model\IsAccessible;

class ArticlePage extends Page implements IsAccessible
{
    use HasAccess;
    public function date_text()
    {
        $carbon = $this->date()->toCarbon();
        return $carbon->format('F d, Y');
    }

    public function author_name()
    {
        if ($this->author()->isEmpty()) {
            return 'CfC St. Moritz';
        } else {
            return $this->author()->toPage()->title();
        }
    }

    public function hasTags($whitelist)
    {
        $tags = $this->tags()->split();
        foreach ($tags as $tag) {
            if (in_array(Str::slug($tag), $whitelist)) {
                return true;
            }
        }
        return false;
    }

    public function related_articles()
    {
        $related = [];
        $articles = site()->index()->filterBy('template', 'article')->filter(function ($article) {
            return $article->uuid()->id() !== $this->uuid()->id();
        });

        foreach ($articles as $article) {
            $currentTags = [];
            foreach ($this->tags()->split() as $tag) {
                $currentTags[] = Str::slug($tag);
            }
            $articleTags = [];

            foreach ($article->tags()->split() as $tag) {
                $articleTags[] = Str::slug($tag);
            }

            $commonTags = array_intersect($articleTags, $currentTags);
            $commonTagCount = count($commonTags);

            if ($commonTagCount > 0) {
                $related[] = [
                    'article' => (string)$article->uuid(),
                    'relevance' => $commonTagCount
                ];
            }

            usort($related, function ($a, $b) {
                return $b['relevance'] - $a['relevance'];
            });

            $temp = new Collection();
            foreach ($related as $item) {
                $temp->add(page($item['article']));
            }
        }

        return $temp->limit(3);
    }
}
