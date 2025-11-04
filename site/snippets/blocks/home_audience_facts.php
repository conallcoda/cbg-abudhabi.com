<?php

$roleImage = $block->role_image();
$sectorsImage = $block->sectors_image();
$speakersImage = $block->speakers_image();

?>

<?php if ($block->title()->isNotEmpty()) : ?>
    <h2><?= $block->title() ?></h2>
<?php endif; ?>
<div class="md:flex gap-4 w-full">

    <div class="flex-[1] flex flex-col gap-4">
        <div class="shadow-md p-4">
            <h4 class="md:text-sm mb-2"><?= $block->admissions_title() ?></h4>
            <div class="flex">
                <div class="flex-[1] pr-4">
                    <div class="font-brown_bold text-[2.5rem] mb-2"><?= $block->net_worth_text() ?></div>
                    <div class="text-xs font-brown_bold"><?= $block->net_worth_title() ?></div>
                </div>
                <div class="flex-[1] border-l border-[#D9D9D9] pl-4">
                    <div class="font-brown_bold text-[2.5rem] mb-2"><?= $block->admission_rate_text() ?></div>
                    <div class="text-xs font-brown_bold"><?= $block->admission_rate_title() ?></div>
                </div>
            </div>
        </div>
        <div class="mt-4 md:mt-0 shadow-md p-4 flex-[1]">
            <h4 class="md:text-sm"><?= $block->role_title() ?></h4>
            <div class="my-4">
                <?php echo $roleImage->_img('default', 'w-full lightbox', '(min-width: 1024px) 33vw, 100vw')
                ?>
            </div>
        </div>
    </div>
    <div class="mt-4 md:mt-0  flex-[1] flex flex-col gap-4">
        <div class="shadow-md p-4 flex-[1]">
            <h4 class="md:text-sm mb-2"><?= $block->investors_title() ?></h4>
            <div class="font-brown_bold text-[2.5rem] mb-2"><?= $block->investors_text() ?></div>
            <div class="text-xs font-brown_bold"><?= $block->investors_subtitle() ?></div>
        </div>
        <div class="mt-4 md:mt-0 shadow-md p-4 flex-[1]">
            <h4 class="text-sm"><?= $block->sectors_title() ?></h4>
            <div class="my-4">
                <?php echo $sectorsImage->_img('default', 'w-full lightbox', '(min-width: 1024px) 33vw, 100vw')
                ?>
            </div>
        </div>
    </div>
    <div class="mt-4 md:mt-0 flex-[1] flex flex-col gap-4">
        <div class="flex-[1] shadow-md p-4">
            <h4 class="md:text-sm mb-2"><?= $block->speakers_title() ?></h4>
            <div class="font-brown_bold text-[2.5rem] mb-2"><?= $block->speakers_text() ?></div>
            <div class="text-xs font-brown_bold"><?= $block->speakers_subtitle() ?></div>
            <div class="my-6">
                <?php echo $speakersImage->_img('default', 'w-full lightbox', '(min-width: 1024px) 33vw, 100vw')
                ?>
            </div>
        </div>
    </div>

</div>