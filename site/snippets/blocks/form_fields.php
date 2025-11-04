<?php

use  CFC\Form\FormFieldsHandler;

$step = $block->parent();
$handler = new FormFieldsHandler($step, $block);
$name = $block->name()->value();
$fields = $handler->getFields();
$showLabels = $block->show_labels()->isTrue();

?>


<form name="<?= $name ?>" data-handler="form-fields">
    <div class="mt-2 md:grid gap-2 grid-cols-2">
        <?php foreach ($fields as $field) : ?>
            <div data-field-type="<?= $field['type'] ?>" data-field-name="<?= $field['name'] ?>" data-field-required="<?= $field['required'] ? 1 : 0 ?>" class="form-row field_<?= $field['name'] ?>">
                <?php if ($showLabels): ?> <div>
                        <?= $field['label'] ?><?= $field['required'] ? '*' : '' ?>
                    </div>
                <?php endif; ?>
                <div>
                    <?php snippet($field['template'], $field); ?>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</form>