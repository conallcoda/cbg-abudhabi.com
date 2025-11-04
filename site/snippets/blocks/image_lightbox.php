<?php

$image = $block->image();
if ($image->isEmpty()) {
  return;
}


?>

<div class="py-4">
  <?php echo $image->_img('full-width', 'w-full lightbox') ?>
</div>