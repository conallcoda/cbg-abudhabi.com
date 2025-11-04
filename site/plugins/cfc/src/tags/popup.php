<?php

use Kirby\Cms\Html;

return [
    'attr' => ['text'],
    'html' => function ($tag) {
        $page = $tag->parent();
        $site = $page->site();


        $url = $tag->value;
        $text = $tag->text;

        $popupPage = $site->find($url);
        $url = $popupPage ? modalUrl($popupPage) : '';

        return Html::a($url, $text,[
            'data-action'=>"burger#openModal"
        ]);
    }
];