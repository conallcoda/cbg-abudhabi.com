<?php

use CFC\Form\AcceptTermsHandler;

$step = $block->parent();
$handler = new AcceptTermsHandler($step, $block);
$fields = $handler->getFields();
$hideTitle = $block->hide_title()->isTrue();
$hideIntro = $block->hide_intro()->isTrue();
$title = (string)$block->title()->or($site->payment_tos_title());
$intro = (string)$block->intro()->or($site->payment_tos_intro());
$disclaimer = (string)$block->disclaimer()->or($site->payment_tos_text());
$name = "terms";

$date = date('Y-m-d H:i:s');
?>

<form name="<?= $name ?>" data-handler="form-fields">
    <?php if (!$hideTitle): ?>
        <h2 class="mt-0"><?= $title ?></h2>
    <?php endif; ?>
    <?php if (!$hideIntro): ?>
        <?= $intro ?>
    <?php endif; ?>
    <div class="form-row checkbox mt-2" data-field-type="checkbox" data-field-name="terms__accept" data-field-required="1">
        <label class="flex justify-center items-center cursor-pointer">
            <input class=" text-black focus:[box-shadow:none]" type="checkbox" value="<?= $date ?>" required>
            <p class="pl-4">
                <?= $disclaimer ?>
            </p>
        </label>
    </div>
</form>