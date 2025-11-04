<?php

?>

<div class="mt-4">
    <?php if ($block->pre_title()->isNotEmpty()): ?>
        <h3 class="underline text-xl leading-none mb-1"><?= $block->pre_title() ?></h3>
    <?php endif; ?>
    <?php if ($block->pre_subtitle()->isNotEmpty()): ?>
        <h4 class="opacity-60 text-[0.95rem] mt-0"><?= $block->pre_subtitle() ?></h4>
    <?php endif; ?>
    <?php if ($block->pre_text()->isNotEmpty()): ?>
        <div class="prose mt-4"><?= $block->pre_text() ?></div>
    <?php endif; ?>
    <?php if ($block->core_title()->isNotEmpty()): ?>
        <h3 class="underline mt-8 text-xl leading-none mb-1"><?= $block->core_title() ?></h3>
    <?php endif; ?>
    <?php if ($block->core_subtitle()->isNotEmpty()): ?>
        <h4 class="opacity-60 text-[0.95rem] mt-0"><?= $block->core_subtitle() ?></h4>
    <?php endif; ?>

    <ul class="md:flex gap-4 mt-4">

        <?php foreach ($block->items()->toStructure() as $item) : ?>
            <li class="mb-4 mt-8 first:mt-0 md:mt-0">
                <div class="mb-4"><a class="text-sm font-brown_bold no-underline pb-2 border-b-2 border-gold" href="<?= $item->link() ?>"><?= $item->title() ?></a> </div>
                <div><?= $item->text() ?></div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>