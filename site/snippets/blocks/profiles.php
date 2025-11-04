<?php



if (isset($block)) {
  $items =  $block->items()->toPages();
  $hideEmail =  $block->hide_email()->isTrue();
  $hideSubtitle =  $block->hide_subtitle()->isTrue();
  $hideCompany = $block->hide_company()->isTrue();
  $itemsPerRow =  $block->items_per_row()->isEmpty() ? 3 : (int)$block->items_per_row()->value();
} else {
  $items = $items ?? [];
  $hideEmail = $hideEmail ?? false;
  $hideSubtitle = $hideSubtitle ?? false;
  $hideCompany = $hideCompany ?? false;
  $itemsPerRow = $itemsPerRow ?? 4;
  $itemsPerRow = (int)$itemsPerRow;
}

$pagination = [
  'limit' => 48,
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

<div <?= $controllerAttr ?>>
  <ul <?= $containerAttr ?> class="mt-8 grid items-stretch grid-cols-2 gap-8 <?= $gridCols ?>">
    <?php foreach ($_items as $item) : ?>
      <?php
      ?>
      <li class="flex flex-col">
        <div class="flex-[1]">
          <div class="aspect-w-8 aspect-h-10">
            <?= $item->picture()->_img('profile', 'grayscale hover:grayscale-0',  '(min-width: 1024px) 25vw, 50vw') ?>
          </div>

          <h5 class="mt-4"><?= $item->title() ?></h5>

          <?php if (!$hideSubtitle) : ?>
            <div class="text font-brown_bold text-sm text-darkGrey"><?= $item->subtitle() ?></div>
          <?php endif; ?>
          <?php if (!$hideCompany) : ?>
            <div class="text font-brown_bold text-sm text-darkGrey group-[.light-background]:text-darkGold"><?= $item->company() ?></div>
          <?php endif; ?>
          <div>
            <?php if (!$hideEmail && !$item->email()->isEmpty()) : ?>
              <div class="my-4">
                <a class="text-darkGold text-sm font-brown_bold" href="mailto:<?= $item->email() ?>"><?= $item->email() ?></a>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <div>
          <div class="flex flex-col-reverse md:flex-row mt-4 md:mt-8 md:items-center">
            <div class="flex-[1] mt-4 md:mt-0">
              <a data-action="burger#openModal" href="<?= $item->url() ?>" class="button grey"><?= $site->read_more_cta() ?></a>
            </div>
            <div>
              <?php snippet('social', ['item' => $item]) ?>
            </div>
          </div>
        </div>

      </li>
    <?php endforeach; ?>
  </ul>
  <?php snippet('infinite-spinner', ['paginate' => $paginate]); ?>
</div>