<?php

$img = include __DIR__ . '/../util/toImage.php';

return function ($preset = 'default', $class = '', $sizes = '100vw') use ($img) {

    return $img($this, $preset, $class, $sizes);
};
