<?php


$img = include __DIR__ . '/../util/toImage.php';

return function ($field, $preset = 'default', $class = '', $sizes = '100vw') use ($img) {

    $image = $field->toFile();
    if (!$image) return null;
    return $img($image, $preset, $class, $sizes);
};
