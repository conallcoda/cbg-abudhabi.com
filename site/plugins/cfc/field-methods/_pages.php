<?php

use Kirby\Cms\Pages;


return function ($field) {

    return $field->toPages();
    $pages = [];
    foreach ($field->split() as $item) {
        $page = page($item);
        if ($page) {
            $pages[] = $page;
        }
    }
    return new Pages($pages);
};
