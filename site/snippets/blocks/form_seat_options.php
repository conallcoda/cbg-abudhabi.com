<?php


$accordions = [
    [
        'icon' => 'ri-check-fill',
        'title' => $block->included_title(),
        'text' => $block->included_text(),
    ],
    [
        'icon' => 'ri-close-large-fill',
        'title' => $block->not_included_title(),
        'text' => $block->not_included_text(),
    ]

];

?>


<div class="form-seat-options">
    <div class="md:grid grid-cols-2 mt-4 mb-4 gap-4">
        <?php foreach ($block->items()->toStructure() as $item) : ?>
            <div class="flex flex-col mt-4">
                <div class="bg-gold uppercase text-center py-1 text-lg font-brown_bold"><?= $item->title() ?></div>
                <div class="bg-black text-white py-2 px-3 my-2 not-prose">
                    <?= $item->subtitle() ?>
                </div>
                <div class="flex-[1]"></div>
                <div class="day-list px-3 border">
                    <?= $item->text() ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div>
        <?php foreach ($accordions as $accordion): ?>
            <div class="accordion mt-2" data-controller="accordion">
                <div class="accordion-item">
                    <div class="flex accordion-header cursor-pointer bg-black text-white py-2 px-3 font-brown_bold text-xl uppercase" data-key="0" data-action="click->accordion#toggle">
                        <div><i class="<?= $accordion['icon'] ?>"> </i></div>
                        <div class="pl-2 flex-[1]"> <?= $accordion['title'] ?></div>
                        <div class="accordion-down">
                            <i class="ri-arrow-down-wide-line"></i>
                        </div>
                        <div class="accordion-up">
                            <i class="ri-arrow-up-wide-line"></i>
                        </div>
                    </div>
                    <div class="included-text px-3 border accordion-content">
                        <?= $accordion['text'] ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>