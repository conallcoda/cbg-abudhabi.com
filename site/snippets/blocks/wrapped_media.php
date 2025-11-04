<?php

if (isset($block)) {
  $blockId = $block->custom_id()->or('b' . $block->id());
  $image = $block->image();
  $text = $block->text()->kt();
  $mediaWidth = $block->media_width()->isEmpty() ? 20 : (int)(string)$block->media_width();
}

$blockId = $blockId ?? null;
$image = $image ?? null;
$text = $text ?? null;
$mediaWidth = $mediaWidth ?? 20;


$styleId = sprintf('#%s .wrapped-media__image', $blockId);


?>

<div class="mt-4 mb-8">
  <style>
    @media screen and (min-width: 800px) {
      <?= $styleId ?> {
        width: <?= $mediaWidth ?>%;
      }
    }
  </style>
  <div class="wrapped-media clearfix">
    <div class="wrapped-media__image md:inline md:pr-4 md:pb-4 md:float-left">
      <?php if ($image) : ?>
        <?= $image->_img('partner', 'w-full') ?>
      <?php endif; ?>
    </div>
    <div class="wrapped-media__text pt-8 md:pt-0">
      <?= $text ?>
    </div>
  </div>
</div>