<?php

use Kirby\Toolkit\Html;

if (isset($image)) {
    $attr = $attr ?? [];
    $preset = $preset ?? 'default';
    $class = $class ?? '';
    $sizes = $sizes ?? '100vw';
    $thumb = $image->thumb($preset);

    $attr['alt'] = $image->alt()->value();
    $attr['class'] = $class;
    $artr['sizes'] = $sizes ?? '100vw';
    $attr['srcset'] = $image->srcset($preset);
    $attr['width'] = $image->width();
    $attr['height'] = $image->height();
    echo Html::img($thumb->url(), $attr);
}
