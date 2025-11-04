<?php

use Kirby\Data\Yaml;
use Kirby\Cms\Layouts;



$templateConfig = [
    'event_day_item' => ['speakers'],
    'event' => ['speakers', 'workshops', 'moderators', 'partners'],
    //'survey' => ['main_question', 'sub_questions', 'optional'],

];

$blockConfig = [
    'blog_author_bio' => ['items'],
    'events' => ['items'],
    'form_fields' => ['items', 'optional'],
    'newsletter' => ['items'],
    'select_product' => ['items'],
    'partners' => ['items'],
    'profiles' => ['items'],

];


return [
    'description' => 'Scaffold templates',
    'args' => [],
    'command' => static function ($cli) use ($templateConfig, $blockConfig): void {
        kirby()->impersonate('kirby');
        $page = page('home');
        $layoutField = $page->layout();

        $layouts = json_decode($layoutField->value(), true);
        foreach ($layouts as $layout) {
            foreach ($layout['columns'] as $column) {
                foreach ($column['blocks'] as $block) {
                    if (in_array($block['type'], array_keys($blockConfig))) {
                        var_dump($block['type']);
                        foreach ($blockConfig[$block['type']] as $field) {
                            if (isset($block['content'][$field])) {
                                if (gettype($block['content'][$field] === 'string')) {
                                    // $block['content'][$field] = explode(',', $block['content'][$field]);
                                }
                            }
                        }
                    }
                }
            }
        }

        $layoutObject =  Layouts::factory(Layouts::parse($layouts), [
            'parent' => $layoutField->parent(),
            'field'  => $layoutField,
        ]);

        $layoutData = json_encode($layoutObject->toArray(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $page->update(['layout_off' => $layoutField->value()]);
    }
];
