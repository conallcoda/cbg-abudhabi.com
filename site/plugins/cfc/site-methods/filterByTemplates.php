<?php

return function ($templates) {
    $ids = explode(',', $templates);
    $filter = function (\Kirby\Cms\Page $page) use ($ids) {
        $template = (string)$page->template();
        return in_array($template, $ids);
    };
    return $this->index(true)->filter($filter);
};
