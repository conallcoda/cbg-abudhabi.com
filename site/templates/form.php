<?php


$gridConfig = [
    'paddingTop' => 'pt-0 md:pt-0',
    'paddingBottom' => 'pb-0 md:pb-0',
    'mainClasses' => 'pt-12 md:pt-12 pb-8 ',
];

$i = 0;

$stepNumber = (int)get('step', 0);
$activeStep = $page->findStep($stepNumber);

$errorConfig = [
    'required' => $site->payment_error_required()->value(),
    'unknown' => $site->payment_error_unknown()->value(),
    'payment' => $site->payment_error_advice()->value(),
];

$submissionId = get('s', '');
if (!$activeStep) {
    die;
}

$backButton = null;

if ($activeStep) {
    $backButton = $page->getBackButtonUrl($activeStep);
    $backButtonText = $activeStep->back_button_text()->or($site->back_button()->value());
}


$isClosed = $page->isClosed();
$activeStep = $isClosed ? null : $activeStep;
$backButton = $isClosed ? null : $backButton;

?>
<?php snippet('layout', slots: true) ?>
<?php if ($backButton): ?>
    <div class="contained pt-16 pb-4">
        <a class="button black hover:text-white" href="<?= $backButton ?>">
            <i class="ri-arrow-left-line"></i> <span class="pb-2"><?= $backButtonText ?></span>
        </a>
    </div>
<?php endif; ?>
<?php if ($activeStep) : ?>
    <div class="prose" data-messages="<?= base64_encode(json_encode($errorConfig)) ?>" data-controller="form-step" data-action="<?= $page->url() ?>" data-t="<?= $page->getAccessToken() ?>" data-step="<?= $stepNumber ?>" data-s="<?= $submissionId ?>">
        <?php if ($activeStep->layout()->isNotEmpty()) : ?>
            <?php snippet('grid', array_merge($gridConfig, ['field' => $activeStep->layout()])) ?>
        <?php endif; ?>
        <div class="contained pb-8">
            <div data-form-step-target="error" class="p-4 text-center text-red">

            </div>
        </div>
    <?php endif; ?>
    <?php if ($isClosed): ?>
        <div class="contained-small text-center pt-4 pb-4">
            <?php snippet('grid', array_merge($gridConfig, ['field' => $page->close_content()])) ?>
        </div>
    </div>
<?php endif; ?>
<?php endsnippet() ?>