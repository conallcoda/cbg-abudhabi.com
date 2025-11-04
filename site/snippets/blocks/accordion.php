<?php
$title = $block->title()->value();
$gridConfig = [
    'containerSize' => '',
    'paddingTop' => 'pt-0 md:pt-0',
    'paddingBottom' => 'pb-0 md:pb-0',
    'mainClasses' => ' ',
];
?>

<div class="accordion" data-controller="accordion">
    <div class="accordion-item">
        <div class="flex  accordion-header cursor-pointer" data-key="0" data-action="click->accordion#toggle">
            <h2 class="grow !mt-0 !mb-0"><?= $title ?></h2>
            <div class="accordion-down text-3xl">
                <i class="ri-arrow-down-wide-line"></i>
            </div>
            <div class="accordion-up text-3xl">
                <i class="ri-arrow-up-wide-line"></i>
            </div>
        </div>
        <div class="accordion-content pt-4">
            <?php if ($block->layout()->isNotEmpty()) : ?>
                <?php snippet('grid', array_merge($gridConfig, ['field' => $block->layout()])) ?>
            <?php endif; ?>
        </div>
    </div>
</div>