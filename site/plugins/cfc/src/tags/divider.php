<?php

return [
    'html' => function ($tag) {
        return snippet('tags/divider', ['size' => $tag->value], true);
    }
];
