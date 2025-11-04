<?php

use  CFC\Form\SurveyHandler;

$source = $block->source()->toPage();
$step = $block->parent();
$handler = new SurveyHandler($step, $block);
$name = $block->name()->value();
$fields = $handler->getFields();
$answerMap = $handler->getAnswerMap();
$answerMap = base64_encode(json_encode($answerMap));
$hasMainQuestion = $handler->hasMainQuestion();


?>
<form name="<?= $name ?>" data-handler="survey-form-fields" data-has-main-question="<?= $hasMainQuestion ? 1 : 0 ?>" class="mt-4 " data-answer-map="<?= $answerMap ?>">
    <?php $i = 0;
    foreach ($fields as $field) : ?>
        <?php

        $widthClass =  $field['type'] === 'survey_radio_boxes' ? 'w-full' : 'w-full';
        ?>
        <div class="form-row survey-form-row" data-is-main-question="<?= $i === 0 ? '1' : '0' ?>" data-field-type="<?= $field['type'] ?>" data-survey-field-name="<?= $field['name'] ?>" data-field-required="<?= $field['required'] ? 1 : 0 ?>">
            <div class="question-title mb-2 font-brown_bold">
                <span class="question-number"><?= $i + 1 ?></span>. <?= $field['label']; ?><?= $field['required'] ? '*' : '' ?>
            </div>
            <div class="mt-2 <?= $widthClass ?>">
                <?php snippet($field['template'], $field); ?>
            </div>
        </div>
    <?php $i++;
    endforeach; ?>
</form>