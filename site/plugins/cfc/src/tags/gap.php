<?php

return [
    'html' => function ($tag) {
        return snippet('tags/gap', ['size' => $tag->value], true);
    }
];
