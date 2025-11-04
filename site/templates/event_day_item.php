<?php
$image = $page->picture();

$gridConfig = [
    'containerSize' => 'contained',
    'mainClasses' => 'pt-4',
    'field' => $page->layout()
];
$related = $page->related_articles();
$speakers = $page->speakers()->_pages();

?>
<?php snippet('layout', slots: true) ?>
<?php snippet('on_off') ?>
<div class="pt-[5rem] md:pt-[7rem] pb-8">
    <header class="pt-8 contained">
        <?= $image->_img('contained', 'w-full') ?>
        <h1 class="text-2xl md:text-3xl mt-8"><?= $page->title() ?></h1>
        <div class="text-lg font-brown_bold mt-4 opacity-60"><?= $page->_time_range() ?></div>
    </header>
    <div class="contained">
        <ul class="flex flex-wrap gap-2 mt-4">
            <?php foreach ($speakers as $speaker) : ?>
                <li class="tag yellow py-1 px-2 font-brown_bold"><?= $speaker->title() ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php if ($page->layout()->isNotEmpty()) : ?>
        <?php snippet('grid', $gridConfig) ?>
    <?php endif; ?>
    <?php if (count($related)) : ?>
        <div class="contained pt-16">
            <h2 class="text-center"> Recommended </h2>
            <div>
                <?php snippet('cards/index', ['items' => $related]) ?>
            </div>
        </div>
    <?php endif; ?>

</div>
<?php endsnippet() ?>