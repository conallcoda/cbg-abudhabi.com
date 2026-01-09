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

$backgroundImage = $site->background_2()->toFile();
if (isset($block)) {
    $newsletter = $block->source()->toPage();
};
if (!$newsletter) {
    return;
}
?><style>
    #bcec24d10-d696-4d33-8f43-96a7b0718605 h2 {
        color: white;
        margin-bottom: 2rem;
    }

    #bcec24d10-d696-4d33-8f43-96a7b0718605 p {
        color: white;
    }
</style>
<div class="relative min-h-[80vh] md:min-h-[50vh] flex items-center">
    <?= $backgroundImage->_img('full-width', 'absolute-fill w-full h-full object-cover ') ?>

    <div class="contained relative">
        <div class="newsletter-home" data-action="<?= $newsletter->url() ?>" data-controller="newsletter" data-messages="<?= base64_encode(json_encode($errorConfig)) ?>">
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
</div>