<?php

$errorConfig = [
    'required' => $site->payment_error_required()->value(),
    'unknown' => $site->payment_error_unknown()->value(),
];
$gridConfig = [
    'paddingTop' => 'pt-0 md:pt-0',
    'paddingBottom' => 'pb-0 md:pb-0',
    'mainClasses' => 'pt-0 pb-0',
];

$newsletter = $site->find('newsletter');
if (!$newsletter) {
    return;
}
?>
<?php snippet('layout', slots: true) ?>
<?php snippet('on_off') ?>
<div class="contained py-4">
    <div class="mt-8" data-action="<?= $newsletter->url() ?>" data-controller="newsletter" data-messages="<?= base64_encode(json_encode($errorConfig)) ?>">
        <?php $i = 0;
        foreach ($newsletter->getSteps() as $step): ?>
            <div class="newsletter-step <?= $i === 0 ? 'active' : 'animate-fadeIn' ?>">
                <?php if ($step->layout()->isNotEmpty()) : ?>
                    <?php snippet('grid', array_merge($gridConfig, ['field' => $step->layout()])) ?>
                <?php endif; ?>
            </div>
        <?php $i++;
        endforeach; ?>
        <div class="text-center text-red" data-newsletter-target="error"></div>
    </div>
</div>
<?php endsnippet() ?>