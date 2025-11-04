<?php



return [
    'description' => 'Nice command',
    'args' => [],
    'command' => static function ($cli): void {
        kirby()->impersonate('kirby');
        $pages = site()->index(true);
        foreach ($pages as $page) {
            foreach ($page->images() as $image) {
                if ((string)$image->template() === 'image') {
                    continue;
                }
                echo $image->url() . PHP_EOL;
                $image->update([
                    'template' => 'image'
                ]);
            }
        }
    }
];
