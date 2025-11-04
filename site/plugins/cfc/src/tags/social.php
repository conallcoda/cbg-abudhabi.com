<?php

return [
    'html' => function ($tag) {
        $urls = explode(',', $tag->value);
        return snippet('tags/social', ['urls' => $urls], true);
    }
];