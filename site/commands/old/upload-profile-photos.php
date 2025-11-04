<?php



return [
    'description' => 'Nice command',
    'args' => [],
    'command' => static function ($cli): void {
        ini_set('memory_limit', '-1');
        kirby()->impersonate('kirby');
        $pages = site()->find('profiles')->children()->template('profile');
        $i = 0;
        foreach ($pages as $page) {

            $title = (string)$page->title();

            $name = str_replace(" ", "", $title);
            $name = iconv("utf-8", "ascii//TRANSLIT", $name);
            $name = preg_replace('/[^A-Za-z0-9 ]/', '', $name);

            $picturePaths = [__DIR__ . '/profiles/' . $name . '.jpg', __DIR__ . '/profiles/' . $name . '.jpeg', __DIR__ . '/profiles/' . $name . '.png'];
            $usedPicturePath = null;
            foreach ($picturePaths as $picturePath) {
                if (file_exists($picturePath)) {
                    $usedPicturePath = $picturePath;
                    continue;
                }
            }

            if (!$usedPicturePath) {
                $i++;
                $cli->out('No picture found for ' . $name);
                continue;
            }
            $existingPaths = [$name . '.jpg', __DIR__ . $name . '.jpeg',  $name . '.png', $name . '.webp'];
            foreach ($existingPaths as $existingPath) {
                if ($existingFIle = $page->files()->find($existingPath)) {
                    $existingFIle->delete();
                }
            }
            try {
                $file = $page->createFile([
                    'source'   => $usedPicturePath,
                    'filename' => basename($usedPicturePath),
                    'template' => 'image',
                ]);
                if ($file) {
                    $page->update([
                        'picture' => '- ' . (string)$file->uuid(),
                    ]);
                }
            } catch (Exception $e) {
                var_dump($e->getMessage());
                $cli->out('Error adding picture for ' . $name);
            }
        }
    }
];
