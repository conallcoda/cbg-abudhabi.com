<?php



return [
    'description' => 'Speaker export',
    'args' => [],
    'command' => static function ($cli): void {
        $page = page('page://8rWRsWcSgNQldy1V');

        foreach ($page->speakers()->toPages() as $speaker) {
            $speakerData[] = [
                'name' => $speaker->title()->value(),
                'bio' => $speaker->bio()->value()
            ];
        }

        $fileName = __DIR__ . '/speaker-data.php';
        file_put_contents($fileName, '<?php' . PHP_EOL . PHP_EOL);
        file_put_contents($fileName, 'return ' . var_export($speakerData, true) . ';', FILE_APPEND);
    }

];
