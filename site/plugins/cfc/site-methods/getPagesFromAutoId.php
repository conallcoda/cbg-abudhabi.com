<?php

return function ($ids) {
    $pages = [];
    foreach ($ids as $id) {
        $page = $this->pages()->autoid($id);
        if (!$page) {
            continue;
        } else {
        }
        $pages[] = $page;
    }
    return $pages;
};
