<?php
$image = $page->picture();

$gridConfig = [
    'containerSize' => 'contained-small',
    'mainClasses' => 'pt-4',
    'field' => $page->layout()
];
$related = $page->related_articles();
$tags = $page->tags()->split();

$newsletter = site()->find('newsletter-report')

?>
<?php snippet('layout', slots: true) ?>
<?php snippet('on_off') ?>
<div class="">
    <div class="contained-small pt-[5rem] md:pt-[7rem] pb-4">
        <?php snippet('blocks/newsletter', ['newsletter' => $newsletter]) ?>
    </div>
    <header class="pt-8 contained-small">
        <?= $image->_img('contained', 'w-full') ?>
        <h1 class="text-2xl md:text-3xl mt-8"><?= $page->title() ?></h1>
        <?php if ($page->subtitle()->isNotEmpty()) : ?>
            <div class="text-lg font-brown_bold mt-4 opacity-60"><?= $page->subtitle() ?></div>
        <?php endif; ?>
    </header>
    <?php if ($page->layout()->isNotEmpty()) : ?>
        <?php snippet('grid', $gridConfig) ?>
    <?php endif; ?>
    <div class="contained-small">
        <ul class="flex flex-wrap gap-2">
            <?php foreach ($tags as $tag) : ?>
                <li class="tag yellow py-1 px-2 font-brown_bold"><?= $tag ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php if (count($related)) : ?>
        <div class="contained-small py-16">
            <h2 class="text-center"> Recommended </h2>
            <div>
                <?php snippet('cards/index', ['items' => $related, 'gridSize' => 'grid-cols-2 md:grid-cols-3']) ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php endsnippet() ?>