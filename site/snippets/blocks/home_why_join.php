<?php

$testimonials = [];
foreach ($block->testimonials()->toStructure() as $item) {
    $testimonials[] = [
        'title' => $item->title()->value(),
        'subtitle' => $item->subtitle()->value(),
        'url' => $item->video_url()->value(),
    ];
}
?>
<div class="md:flex gap-8">
    <div class="flex-[0_0_40%]">
        <?php if ($block->title()->isNotEmpty()) : ?>
            <h2><?= $block->title() ?></h2>
        <?php endif; ?>
        <?= $block->intro()->kt() ?>
        <div class="mt-8 md:mt-16 md:pr-16">
            <?php snippet('carousel', ['items' => $testimonials, 'template' => 'testimonial']) ?>
        </div>
    </div>

    <div class="mt-8 md:mt-0 flex-[0_0_60%]">
        <ul class="bg-grey p-4 md:p-8 rounded-lg">
            <?php foreach ($block->investor_types()->toStructure() as $item) : ?>
                <li class="first:mt-0 mt-8 bg-white p-6 md:p-6 rounded-lg shadow">
                    <h4 class="mt-0 mb-2"><?= $item->title() ?></h4>
                    <div class="prose text-sm">
                        <?= $item->text()->kti() ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php if ($block->investor_text()->isNotEmpty()): ?>
            <div class="prose text-sm md:px-8 text-center mt-8">
                <?= $block->investor_text()->kti() ?>
            </div>
        <?php endif; ?>
    </div>
</div>