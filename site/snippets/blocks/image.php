<?php

$image = $block->image();
$width = $block->width();


$widthClass = match ((int)$width->value()) {
  10 => 'md:w-[10%]',
  20 => 'md:w-[20%]',
  30 => 'md:w-[30%]',
  40 => 'md:w-[40%]',
  50 => 'md:w-[50%]',
  60 => 'md:w-[60%]',
  70 => 'md:w-[70%]',
  80 => 'md:w-[80%]',
  90 => 'md:w-[90%]',
  100 => 'md:w-[100%]',
  default => ''
};

?>
<div class="md:flex md:justify-center">
  <div class="<?= $widthClass ?>">
    <?= $image->_img('full-width', 'w-full h-auto') ?>
  </div>
</div>