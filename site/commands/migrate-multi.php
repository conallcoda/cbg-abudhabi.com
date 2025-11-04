<?php

use Kirby\Data\Yaml;
use Kirby\Cms\Layouts;



$templateConfig = [
    'event_day_item' => ['speakers'],
    'event' => ['partners', 'speakers', 'workshops', 'moderators'],
    //'survey' => ['main_question', 'sub_questions', 'optional'],

];

$blockConfig = [
    'blog_author_bio' => ['author'],
    'events' => ['items'],
    'form_fields' => ['items', 'optional'],
    'newsletter' => ['items'],
    'form_select_product' => ['items'],
    'partners' => ['items'],
    'profiles' => ['items'],

];


return [
    'description' => 'Scaffold templates',
    'args' => [],
    'command' => static function ($cli) use ($templateConfig, $blockConfig): void {
        kirby()->impersonate('kirby');


        $pages = site()->index(true)->filterBy('template', 'in', ['event', 'event_day_item']);
        // $pages = site()->index(true);1

        foreach ($pages as $page) {


            $cli->out('Migrating ' . $page->id());
            $template = (string)$page->template();


            $update = [];

            if (in_array($template, array_keys($templateConfig))) {
                foreach ($templateConfig[$template] as $field) {
                    if ($page->$field()->isEmpty()) {
                        continue;
                    }
                    $cli->out($field);
                    $initialValue = $page->$field()->value();
                    if ($template === 'event' && $field === 'partners') {
                        $temp = [];
                        $initialValue = $page->$field()->toStructure()->toArray();
                        foreach ($initialValue as $item) {
                            $tempPartners = [];
                            $items = explode(',', $item['partners']);
                            foreach ($items as $_item) {
                                $tempPartners[] = trim($_item);
                            }
                            $temp[] = ['id' => $item['id'], 'partners' => $tempPartners, 'title' => $item['title']];
                        }
                        $update[$field] = Yaml::encode($temp);
                    } else if (gettype($initialValue) === 'string') {
                        $temp = [];
                        $items = explode(',', $page->$field()->value());
                        foreach ($items as $item) {
                            $temp[] = trim($item);
                        }
                        $update[$field] = $temp;
                    }
                }
            }

            $layoutFieldNames = ['layout', 'layout_off'];
            foreach ($layoutFieldNames as $layoutFieldName) {
                if ($page->$layoutFieldName()->isEmpty()) {
                    continue;
                }
                $layoutField  = $page->$layoutFieldName();
                $layouts = json_decode($layoutField->value(), true);
                if (empty($layouts)) {
                    continue;
                }
                foreach ($layouts as &$layout) {
                    foreach ($layout['columns'] as &$column) {
                        foreach ($column['blocks'] as &$block) {
                            if (in_array($block['type'], array_keys($blockConfig))) {
                                $cli->out('Migrating ' . $block['type']);
                                foreach ($blockConfig[$block['type']] as $field) {
                                    if (isset($block['content'][$field])) {
                                        if (gettype($block['content'][$field]) === 'string') {
                                            var_dump($block['content'][$field]);
                                            $items = explode(',', $block['content'][$field]);
                                            $block['content'][$field] = [];
                                            foreach ($items as $item) {
                                                $block['content'][$field][] = trim($item);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $layoutData = json_encode($layouts, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                $update[$layoutFieldName] = $layoutData;
            }
            if (!empty($update)) {
                $page->update($update);
            }
        }
    }
];
