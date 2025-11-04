<?php

use CFC\Model\HasAccess;
use CFC\Model\IsAccessible;

class ProfilePage extends Page implements IsAccessible
{
    use HasAccess;

    public function profile_picture()
    {
        if ($this->picture_color()->isNotEmpty()) {
            return $this->picture_color();
        }

        if ($this->picture()->isNotEmpty()) {
            return $this->picture();
        }

        return $this->picture_cropped();
    }

    public function _logo_ratio()
    {
        $file = $this->logo()->toFile();
        if (!$file) {
            return 0;
        }
        $dimensions = $file->dimensions();
        $width = $dimensions->width();
        $height = $dimensions->height();
        return round($width / $height, 2);
    }
}
