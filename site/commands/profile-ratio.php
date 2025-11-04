<?php

use Kirby\Uuid\Uuid;

return [
    'description' => 'Scaffold templates',
    'args' => [],
    'command' => static function ($cli): void {
        kirby()->impersonate('kirby');
        $profiles = site()->find('profiles')->children()->template('profile');
        $result = [];
        foreach ($profiles as $profile) {
            $logo = $profile->logo()->toFile();
            if (!$logo) {
                continue;
            }
            $dimensions = $logo->dimensions();
            $width = $dimensions->width();
            $height = $dimensions->height();
            $ratio = $width / $height;
            $ratio = round($ratio * 10);

            if (!isset($result[$ratio])) {
                $cli->out($profile->title() . ': ' . $ratio);
                $result[$ratio] = $profile->uuid()->id();
            }
        }
        sort($result);
        var_export($result);
    }
];
