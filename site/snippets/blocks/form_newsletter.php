<?php

use  CFC\Form\FormFieldsHandler;


$step = $block->parent();
$handler = new FormFieldsHandler($step, $block);

$fields = $handler->getFields();

$submitText = $block->button()->value();
$newsletterPage = $site->find('newsletter');
$gridClass = $newsletterPage->uuid()->id() === $page->uuid()->id() ? 'grid-cols-1' : 'grid-cols-4';
?>

<form name="contact" data-newsletter-target="form">
    <div class="mt-2 md:grid  <?= $gridClass ?>">
        <?php foreach ($fields as $field) : ?>
            <div data-field-type="<?= $field['type'] ?>" data-field-name="<?= $field['name'] ?>" data-field-required="<?= $field['required'] ? 1 : 0 ?>" class="form-row newsletter field_<?= $field['name'] ?>">
                <?php snippet($field['template'], $field); ?>
            </div>
        <?php endforeach; ?>
        <div class="form-row newsletter submit">
            <button data-action="newsletter#next" class="button black newsletter"><?= $submitText ?></a>
        </div>
    </div>
</form>