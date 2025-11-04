<?php


use CFC\Util\ConfigHelper;


Kirby::plugin('coda/cfc', [
    'sections' => [
        'submissions' => require __DIR__ . '/sections/submissions.php',
        'submission' => require __DIR__ . '/sections/submission.php',
    ],
    'tags' => [
        'youtube' => include_once __DIR__ . '/src/tags/youtube.php',
        'section' => include_once __DIR__ . '/src/tags/section.php',
        'media' => include_once __DIR__ . '/src/tags/media.php',
        'gap' => include_once __DIR__ . '/src/tags/gap.php',
        'social' => include_once __DIR__ . '/src/tags/social.php',
    ],
    'icons' => [],
    'fileMethods' => ConfigHelper::getFunctions(__DIR__ . '/file-methods'),
    'fieldMethods' => ConfigHelper::getFunctions(__DIR__ . '/field-methods'),
    'pageMethods' => ConfigHelper::getFunctions(__DIR__ . '/page-methods'),
    'siteMethods' => ConfigHelper::getFunctions(__DIR__ . '/site-methods'),
    'api' => [
        'routes' =>     [
            [
                'pattern' => 'page-data/(:alphanum)',
                'action' => function ($uuid) {
                    $page = page('page://' . $uuid);
                    if (!$page) {
                        return ['status' => 'error', 'code' => 404];
                    }
                    $data = ['title' => (string)$page->title()];
                    if (isset(get('params')['fields'])) {
                        $fields = explode(',', get('params')['fields']);
                        foreach ($fields as $field) {
                            $data[$field] = (string)$page->$field();
                        }
                    }
                    return $data;
                }
            ],
        ],

    ]
]);
