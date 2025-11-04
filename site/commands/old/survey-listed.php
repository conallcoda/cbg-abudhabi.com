<?php

$survey = include __DIR__ . '/survey.php';

return [
    'description' => 'Nice command',
    'args' => [],
    'command' => static function ($cli) use ($survey): void {
        kirby()->impersonate('kirby');
        $page = site()->find('surveys/application-survey-2024');
        $i = 1;
        foreach ($survey as $item) {
            $slug = str_replace('_', '-', $item['slug']);
            $field = $page->find($slug);
            $field->changeNum($i);
            $i++;
        }
    }
];
