<?php

use Kirby\Cms\Field;

return function ($ids) {
    if ($ids instanceof Field) {
        $ids = $ids->split();
    } else  if (is_string($ids)) {
        $ids = explode(',', $ids);
    }

    $pages = [];
    foreach ($ids as $id) {
        $page = $this->findPageFromUuid($id);
        if (!$page) {
            continue;
        }
        $pages[] = $page;
    }
    return $pages;
};
