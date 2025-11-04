<?php

use Kirby\Toolkit\Html;

return function ($field, $text = null, $class = '', $openInNewTab = false) {
    $url = $field->toUrl();
    $page = $page = page($field->value());
    if (empty($text) && $page) {
        $text = $page->title()->or($field->value());
    }

    if (!empty($page)) {
        $url = empty($page->_preview_url()) ? $url : $page->_preview_url();
    }

    $attrs = [
        'href' => $url,
        'class' => $class,
        'target' => $openInNewTab ? '_blank' : null
    ];
    return  Html::tag('a', $text, $attrs);
};
