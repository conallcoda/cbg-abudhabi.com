<?php

use Kirby\Toolkit\Str;

return [
    'description' => 'Nice command',
    'args' => [],
    'command' => static function ($cli): void {
        kirby()->impersonate('kirby');
        $pages = site()->index(true)->filterBy('template', 'profile');
        $csv = [];
        foreach ($pages as $page) {
            if ($page->picture()->isEmpty()) {
                $id = $page->id();
                $title = (string)$page->title();
                $name = str_replace(" ", "", $title);
                $name = iconv("utf-8", "ascii//TRANSLIT", $name);
                $name = preg_replace('/[^A-Za-z0-9 ]/', '', $name);
                $csv[] = sprintf('"%s","%s","%s"', $id, $title, $name);
            }
        }




        file_put_contents('profiles.csv', implode(PHP_EOL, $csv));
    }
];
