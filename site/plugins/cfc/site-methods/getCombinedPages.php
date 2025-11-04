<?php

return function ($parentIds, $includeSitePages = true) {
    $ids = explode(',', $parentIds);
    $pages = new \Kirby\Cms\Pages();
    $aggregated = $includeSitePages ? [$this->children()] : [];
    foreach ($ids as $id) {
        $p = $this->find($id);
        if ($p) {
            $aggregated[] = $this->find($id)->children();
        }
    }
    foreach ($aggregated as $collection) {
        $pages->add($collection);
    }
    return $pages;
};
