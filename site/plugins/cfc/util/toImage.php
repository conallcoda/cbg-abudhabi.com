<?php

use Kirby\Toolkit\Html;


return function ($image, $preset = 'default', $class = '', $sizes = '100vw') {

    $containerClass = '';
    $containerController = '';
    $containerAction = '';
    $presetPng = $preset . '-png';

    $thumb = $image->thumb($presetPng);
    $attr['alt'] = $image->alt()->value();
    $attr['class'] = $class;
    $attr['sizes'] = $sizes;
    $attr['srcset'] = $image->srcset($presetPng);
    $attr['width'] = $image->width();
    $attr['height'] = $image->height();

    if (strpos($class, 'lightbox') !== false) {
        $attr['data-lightbox-target'] = 'image';
        $class = str_replace('lightbox', '', $class);
        $containerClass .= 'lightbox';
        $containerController = 'data-controller="lightbox" ';
        $containerController .= sprintf('data-lightbox-url="%s"',  $image->thumb('full-width')->url());
        $containerAction = 'data-action="click->lightbox#open" ';
    }

    $picture = Html::tag('picture', [
        Html::tag('source', '', [
            'srcset' => $image->srcset($preset),
            'sizes' => $sizes,
            'type' => 'image/webp',
        ]),
        Html::img($thumb->url(), $attr)
    ]);

    return sprintf('<div %s%sclass="%s">%s</div>', $containerController, $containerAction, $containerClass, $picture);
};
