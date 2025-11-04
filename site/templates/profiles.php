<?php snippet('layout', slots: true) ?>
<?php snippet('on_off') ?>
<?php




$items = site()->find('profiles')->children()->template('profile');

$hideEmail = $hideEmail ?? false;
$hideSubtitle = $hideSubtitle ?? false;
$hideCompany = $hideCompany ?? false;
$itemsPerRow = $itemsPerRow ?? 4;
$itemsPerRow = (int)$itemsPerRow;

$blockId = 'profiles_test';


$pagination = [
    'limit' => 5000,
    'id' => $blockId ?? $block->id()
];

[
    'paginate' => $paginate,
    'controllerAttr' => $controllerAttr,
    'containerAttr' => $containerAttr,
    '_items' => $_items,
]
    = site()->_paginate($pagination, $items);

$gridCols = match ($itemsPerRow) {
    3 => 'md:gap-12 md:grid-cols-3',
    default => 'md:gap-8 md:grid-cols-4',
};
?>
<div class="contained">
    <div <?= $controllerAttr ?>>
        <ul <?= $containerAttr ?> class="mt-8 grid items-stretch grid-cols-2 gap-8 <?= $gridCols ?>">
            <?php foreach ($_items as $item) : ?>
                <?php
                $pictureWidth = 0;
                $pictureHeight = 0;
                if ($picture = $item->profile_picture()->toFile()) {
                    $pictureWidth = $picture->width();
                    $pictureHeight = $picture->height();
                }


                ?>
                <li class="flex flex-col">
                    <div class="flex-[1]">
                        <?php if ($picture): ?>
                            <div class="aspect-w-8 aspect-h-10">
                                <?= $picture->_img('grayscale hover:grayscale-0', '',  '(min-width: 1024px) 25vw, 50vw') ?>
                            </div>
                        <?php endif; ?>
                        <h5 class="mt-4"><?= $item->title() ?></h5>

                        <div>
                            <?= $pictureWidth ?>x<?= $pictureHeight ?>
                        </div>

                    </div>

                    <div>
                        <div class="flex flex-col-reverse md:flex-row mt-4 md:mt-8 md:items-center">
                            <div class="flex-[1] mt-4 md:mt-0">
                                <a href="<?= $item->panel()->url() ?>" target="_blank" class="button grey">PANEL</a>
                            </div>

                        </div>
                    </div>

                </li>
            <?php endforeach; ?>
        </ul>
        <?php snippet('infinite-spinner', ['paginate' => $paginate]); ?>
    </div>
</div>
<?php endsnippet() ?>