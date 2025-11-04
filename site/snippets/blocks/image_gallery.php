<?php
$itemsPerRowDesktop = $itemsPerRowDesktop ?? 3;
$itemsPerRowMobile = $itemsPerRowMobile ?? 2;
$images = $images ?? [];
if (isset($block)) {
  $itemsPerRowDesktop = $block->items_per_row_desktop()->isNotEmpty() ? (int)$block->items_per_row_desktop()->value() : $itemsPerRowDesktop;
  $itemsPerRowMobile = $block->items_per_row_mobile()->isNotEmpty() ? (int)$block->items_per_row_mobile()->value() : $itemsPerRowMobile;
  $images = $block->images()->toFiles();
}

$gridClass = sprintf('grid-cols-%d md:grid-cols-%d', $itemsPerRowMobile, $itemsPerRowDesktop);
$mobileSizes = 100 / $itemsPerRowMobile . 'w';
$deskTopSizes = 100 / $itemsPerRowDesktop . 'w';
$itemSizes = sprintf('(min-width: 1024px) %s, %s', $deskTopSizes, $mobileSizes);

?>

<div class="grid gap-4 <?= $gridClass ?>">
  <?php foreach ($images as $image): ?>
    <?php echo $image->_img('gallery', 'w-full lightbox', $itemSizes) ?>
  <?php endforeach; ?>
</div>