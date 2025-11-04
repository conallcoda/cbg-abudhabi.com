<?php

$pictures = include __DIR__ . '/pictures.php';

return [
    'description' => 'Nice command',
    'args' => [],
    'command' => static function ($cli) use ($pictures): void {
        kirby()->impersonate('kirby');
        $page = site()->find('surveys/applicant-survey-2024');
        $questions = [];
        foreach ($page->questions()->toStructure() as $item) {
            $question = [
                'slug' => (string)$item->name(),
                'required' => $item->required()->isTrue(),
                'type' => (string)$item->type(),
                'multiple_answers_allow' => $item->multiple_answers_allow()->isTrue(),
                'multiple_answers_allow_other' => $item->multiple_answers_allow_other()->isTrue(),
                'placeholder' => $item->placeholder()->value(),
                'question' => $item->question()->value(),
                'options' => [],
            ];
            foreach ($item->options()->toStructure() as $option) {
                $question['options'][] = [(string)$option->title()];
            }
            $questions[] = $question;
        }

        file_put_contents('survey.php', '<?php return ' . var_export($questions, true) . ';');
    }
];
