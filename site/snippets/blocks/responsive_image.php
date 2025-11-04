<?php

$imageDesktop = $block->image();
$imageMobile = $block->image_mobile();

if ($imageMobile->isEmpty()) {
  $imageMobile = $imageDesktop;
}

?>

<div>
  <?= $imageDesktop->_img('full-width', 'hidden md:block w-full h-auto') ?>
  <?= $imageMobile->_img('full-width', 'md:hidden w-full h-auto') ?>
</div>