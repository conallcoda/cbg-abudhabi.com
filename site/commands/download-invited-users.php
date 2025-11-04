<?php

use Bnomei\Janitor;
use Kirby\CLI\CLI;

return [
    'description' => 'Example',
    'args' => [] + Janitor::ARGS,
    'command' => static function ($cli): void {
        $page = page($cli->arg('page'));
        $uuid = (string)$page->uuid()->id();
    }
];
