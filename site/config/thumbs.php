<?php


$thumbs =   [
    'presets' => [
        'default' => ['width' => 300, 'format' => 'webp'],
        'profile' => ['width' => 160, 'height' => 160 * 1.25, 'grayscale' => true, 'crop' => true, 'format' => 'webp'],
        'card' => ['height' => 300, 'width' => 300 * 0.9, 'format' => 'webp'],
        'gallery' => ['width' => 400, 'height' => 300, 'format' => 'webp'],
        'full-width' => ['width' => 2560, 'format' => 'webp'],

    ],
    'srcsets' => [
        'profile' => [
            '160w' => ['width' => 160, 'height' =>  160 * 1.25,  'crop' =>   true, 'format' => 'webp'],
            '200w' => ['width' => 200, 'height' =>  200 * 1.25,  'crop' =>   true, 'format' => 'webp'],
            '320w' => ['width' => 320, 'height' =>  320 * 1.25,  'crop' =>   true, 'format' => 'webp'],
            '440w' => ['width' => 440, 'height' =>  440 * 1.25, 'crop' =>   true, 'format' => 'webp'],
            '600w' => ['width' => 600, 'height' =>  600 * 1.25, 'crop' =>   true, 'format' => 'webp'],
        ],
        'card' => [
            '160w' => ['width' => 160, 'height' =>  160 * 0.9, 'crop' =>   true, 'format' => 'webp'],
            '200w' => ['width' => 200, 'height' =>  200 * 0.9, 'crop' =>   true, 'format' => 'webp'],
            '320w' => ['width' => 320, 'height' =>  320 * 0.9,  'crop' =>   true, 'format' => 'webp'],
            '440w' => ['width' => 440, 'height' =>  440 * 0.9, 'crop' =>   true, 'format' => 'webp'],
            '600w' => ['width' => 600, 'height' =>  600 * 0.9,  'crop' =>   true, 'format' => 'webp'],
        ],
        'partner' => [
            '160w' => ['width' => 160, 'format' => 'webp'],
            '200w' => ['width' => 200, 'format' => 'webp'],
            '320w' => ['width' => 320, 'format' => 'webp'],
            '440w' => ['width' => 440, 'format' => 'webp'],
            '600w' => ['width' => 600, 'format' => 'webp'],
        ],
        'gallery' => [
            '160w' => ['width' => 160, 'height' =>  160 * 0.75,  'crop' =>   true, 'format' => 'webp'],
            '200w' => ['width' => 200, 'height' =>  200 * 0.75,  'crop' =>   true, 'format' => 'webp'],
            '320w' => ['width' => 320, 'height' =>  320 * 0.75,  'crop' =>   true, 'format' => 'webp'],
            '440w' => ['width' => 440, 'height' =>  440 * 0.75, 'crop' =>   true, 'format' => 'webp'],
            '600w' => ['width' => 600, 'height' =>  600 * 0.75, 'crop' =>   true, 'format' => 'webp'],
        ],

        'default' => [
            '320w' => ['width' => 300, 'format' => 'webp'],
            '640w' => ['width' => 640, 'format' => 'webp'],
            '1024w' => ['width' => 1024, 'format' => 'webp'],
            '1440w' => ['width' => 1440, 'format' => 'webp'],
        ],
        'full-width' => [
            '320w' => ['width' => 300, 'format' => 'webp'],
            '640w' => ['width' => 640, 'format' => 'webp'],
            '1024w' => ['width' => 1024, 'format' => 'webp'],
            '1440w' => ['width' => 1440, 'format' => 'webp'],
            '1920w' => ['width' => 1920, 'format' => 'webp'],
            '2560w' => ['width' => 2560, 'format' => 'webp'],
        ]
    ]
];


foreach ($thumbs['presets'] as $key => $value) {
    $value['format'] = 'png';
    $thumbs['presets'][$key . '-png'] = $value;
}

foreach ($thumbs['srcsets'] as $key => $value) {
    foreach ($value as $key2 => $value2) {
        $value2['format'] = 'png';
        $thumbs['srcsets'][$key . '-png'][$key2] = $value2;
    }
}

return ['thumbs' => $thumbs];
