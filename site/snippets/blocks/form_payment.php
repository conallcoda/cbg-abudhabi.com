<?php

use CFC\Form\PaymentHandler;


$step = $block->parent();
$handler = new PaymentHandler($step, $block);
$name = 'billing';
$fields = $handler->getFields();
$submission = $step->parent()->getSubmission();
$cart = $submission->getCart();
$summary = $cart->toSummary();

$allowReduction = $block->allow_reduction_codes()->isTrue();
$reductionAction = sprintf('/forms/%s/%s/apply-reduction/', $page->uuid()->id(), $submission->uuid()->id());
$reductionInputConfig = [
    'placeholder' => 'Reservation Code',
    'name' => 'reduction_code',
    'classNames' => 'reduction-input'
];

$hasReduction = $cart->hasReduction();

$summaryTitle = $block->summary_title()->or("Summary");
?>
<form name="<?= $name ?>" data-handler="payment-form-fields" <?= $submission->_stripe_attributes() ?>>
    <h2 class="mt-0"><?= $summaryTitle ?></h2>
    <div class="payment-summary" data-controller="reduction-code" data-end-point="<?= $reductionAction ?>">
        <div data-reduction-code-target="summary">
            <?= snippet('payment-summary', ['summary' => $summary, 'hasReduction' => $hasReduction]) ?>
        </div>
        <?php if ($allowReduction): ?>
            <div class="flex">
                <div class="grow"></div>
                <div class="">
                    <div class="flex items-center justify-end">
                        <div class="">
                            <?php snippet('form/input', $reductionInputConfig) ?>
                        </div class="">
                        <div class="pl-4"><a data-action="reduction-code#apply" class="button black reduction-code">Update</a></div>
                    </div>
                    <div class="reduction-error py-4 text-red"></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php snippet('blocks/divider') ?>
    <h2 class="mt-0">Payment Details</h2>
    <div class="md:grid gap-2 grid-cols-2">
        <?php foreach ($fields as $field) : ?>
            <div data-field-type="input" data-field-name="<?= $field['name'] ?>" data-field-required="<?= $field['required'] ? 1 : 0 ?>" class="form-row field_<?= $field['name'] ?>">
                <?php snippet($field['template'], $field); ?>
            </div>
        <?php endforeach; ?>

        <div id="card-element-container" class="form-row col-span-2">
            <div class="bg-grey border-0 w-full py-[1.1rem] px-4" id="card-element">
            </div>
            <div class="error" id="card-errors" role="alert">
            </div>
        </div>

    </div>
</form>