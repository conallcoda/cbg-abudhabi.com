<?php


$backgroundImage = $site->background_1()->toFile();
?>
<div>
    <div class="contained relative z-10 pt-16 md:pt-0 md:translate-y-32">
        <div class="md:flex-row flex flex-col">
            <div class="flex-[0_0_50%]">
                <h2> <?= $block->title()->kti() ?></h2>

            </div>

            <div class="flex-[1] leading-6  md:pb-4 pt-8 md:pt-0">
                <?= $block->text()->kti() ?>
            </div>
        </div>
    </div>
    <?php if ($backgroundImage): ?>
        <?= $backgroundImage->_img('full-width', 'w-full h-auto relative ') ?>
    <?php endif; ?>
</div>