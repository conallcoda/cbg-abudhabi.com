<?php

use Bnomei\Janitor;
use Kirby\CLI\CLI;

return [
    'description' => 'Copy On Season',
    'args' => [] + Janitor::ARGS,
    'command' => static function ($cli): void {
        $page = page($cli->arg('page'));
        $page->update(
            ['layout_off' => $page->layout()->value()]
        );

        janitor()->data($cli->arg('command'), [
            'status' => 200,
            'reload' => true,
        ]);
    }
];
