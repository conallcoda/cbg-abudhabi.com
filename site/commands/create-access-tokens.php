<?php

use Kirby\Uuid\Uuid;

return [
    'description' => 'Scaffold templates',
    'args' => [],
    'command' => static function ($cli): void {
        kirby()->impersonate('kirby');
        $pages = kirby()->site()->index(true)->template('default');
        foreach ($pages as $page) {
            $cli->out($page->id());
            $page->update(['access_token' => Uuid::generate()]);
        }
    }
];
