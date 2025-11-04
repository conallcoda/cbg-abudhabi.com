<?php


return function ($path, $template) {
    $cacheKey = $path .  $template;


    $cache = kirby()->cache('cfc')->get($cacheKey);
    if (!$cache) {
        $temp = [];
        $pages = site()->find($path)->children()->template($template);
        foreach ($pages as $page) {

            $temp[] = [
                'uuid' => (string)$page->uuid(),
                'title' => (string)$page->title()
            ];
        }
        kirby()->cache('cfc')->set($cacheKey, $temp, 1);
        return $temp;
    }
    return $cache;
};
