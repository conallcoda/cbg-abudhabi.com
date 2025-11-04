<?php

use Kirby\Data\Yaml;

$surveyData = include __DIR__ . '/survey.php';

return [
    'description' => 'Nice command',
    'args' => [],
    'command' => static function ($cli) use ($surveyData): void {
        kirby()->impersonate('kirby');
        $surveys = site()->find('surveys');
        foreach ($surveyData as $item) {
            $pageData = [
                'slug' => str_replace('_', '-', $item['slug']),
                'draft' => false,
                'template' => 'form_field',
                'content' => [
                    'title' => $item['question'],
                    'type' => $item['type'],
                    'multiple_answers_allow' => $item['multiple_answers_allow'],
                    'multiple_answers_allow_other' => $item['multiple_answers_allow_other'],
                    'placeholder' => $item['placeholder'],
                    'options' => [],
                ],

            ];
            foreach ($item['options'] as $option) {

                $pageData['content']['options'][] = ['title' => $option[0]];
            }

            $pageData['content']['options'] = Yaml::encode($pageData['content']['options']);
            $field = $surveys->createChild($pageData);
            var_dump($field->id());
        }
    }
];
