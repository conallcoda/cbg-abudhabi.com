<?php

$testimonials = [];
foreach ($block->testimonials()->toStructure() as $item) {
    $testimonials[] = [
        'title' => $item->title()->value(),
        'subtitle' => $item->subtitle()->value(),
        'url' => $item->video_url()->value(),
    ];
}

$testimonialImage = $block->testimonial_image()->toFile();
?>
<div class="md:flex gap-24 items-center mt-8 mb-8 md:mt-16 md:mb-12">
    <div class="flex-[0_0_50%]">
        <?php if ($block->title()->isNotEmpty()) : ?>
            <h2><?= $block->title() ?></h2>
        <?php endif; ?>
        <?= $block->intro()->kt() ?>
        <div class="mt-8 md:mt-16 md:pr-16">
            <?php snippet('carousel', ['items' => $testimonials, 'template' => 'testimonial']) ?>
        </div>
    </div>

    <div class=" md:mt-0 flex-[0_0_50%]">
        <?php if ($testimonialImage): ?>
            <?= $testimonialImage->_img('full-width', 'w-full mb-8') ?>
        <?php endif; ?>

    </div>
</div>
<ul class="flex flex-col md:flex-row gap-8">
    <?php foreach ($block->investor_types()->toStructure() as $item) : ?>
        <li class="first:mt-0">
            <h4 class="mt-0 mb-4 text-lg font-brown_bold"><?= $item->title() ?></h4>
            <div class="prose text-sm !text-black/65">
                <?= $item->text()->kti() ?>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
<?php if ($block->investor_text()->isNotEmpty()): ?>
    <div class="prose text-sm  text-center mt-12">
        <?= $block->investor_text()->kti() ?>
    </div>
<?php endif; ?>