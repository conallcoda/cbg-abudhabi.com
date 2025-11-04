<?php



return [
    'description' => 'Nice command',
    'args' => [],
    'command' => static function ($cli): void {
        ini_set('memory_limit', '-1');
        kirby()->impersonate('kirby');
        $pages = site()->find('profiles')->children()->template('profile');
        $i = 0;
        $foundCount = 0;
        $foundList = [];
        $notFoundCount = 0;
        $notFoundList = [];
        foreach ($pages as $page) {

            if ($page->picture_color()->isNotEmpty()) {
                $cli->out('Skipping ' . $page->title() . ' because picture_color is already set.');
                continue;
            }
            $title = (string)$page->title();

            $name = str_replace(" ", "", $title);
            $name = iconv("utf-8", "ascii//TRANSLIT", $name);
            $name = preg_replace('/[^A-Za-z0-9 ]/', '', $name);

            $picturePaths = [
                __DIR__ . '/profiles/' . $name . '_original.jpg',
                __DIR__ . '/profiles/' . $name . '_original.jpeg',
                __DIR__ . '/profiles/' . $name . '_original.png',
                __DIR__ . '/profiles/' . $name . '_original.webp'
            ];
            $usedPicturePath = null;
            foreach ($picturePaths as $picturePath) {
                if (file_exists($picturePath)) {
                    $usedPicturePath = $picturePath;
                    continue;
                }
            }

            if (!$usedPicturePath) {
                $i++;
                $notFoundCount++;
                $notFoundList[] = $name . '_original';
                $cli->out('No picture found for ' . $name);
                continue;
            } else {
                $i++;
                $cli->out('Found picture for ' . $name);
                $foundCount++;
                $newFileName = str_replace('_original', '_original_color', basename($usedPicturePath));
                $file = $page->createFile([
                    'source'   => $usedPicturePath,
                    'filename' => $newFileName,
                    'template' => 'image',
                ]);
                if ($file) {
                    $page->update([
                        'picture_color' => '- ' . (string)$file->uuid(),
                    ]);
                }
            }
        }
    }
];
