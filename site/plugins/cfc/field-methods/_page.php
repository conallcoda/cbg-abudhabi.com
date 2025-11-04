<?php

use Kirby\Cms\Pages;


return function ($field) {

    return $field->toPage();
    $pages = [];
    foreach ($field->split() as $item) {
        $page = page($item);
        if ($page) {
            $pages[] = $page;
        }
    }
    if (count($pages)) {
        return $pages[0];
    } else {
        return null;
    }
};
