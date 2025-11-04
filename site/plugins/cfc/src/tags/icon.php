<?php

return [
    'html' => function ($tag) {
        return sprintf('<i class="fa fa-%s"></i>', $tag->value);
    }
];
