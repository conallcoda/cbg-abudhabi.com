<?php

if (isset($block)) {
  $items = $block->items()->_pages();
}

$items = $items ?? [];
?>

<ul class="mt-8 grid items-stretch grid-cols-2 md:grid-cols-4 gap-8">
  <?php foreach ($items as $item) : ?>
    <?php
    $image = $item->picture();
    ?>
    <li>
      <a class="partner-link" href="<?= $item->link() ?>" target="_blank" rel="noopener nnofollow">
        <div class="inner">
          <div class="">
            <?= $item->picture()->_img('partner', 'w-full h-auto grayscale hover:grayscale-0',  '(min-width: 1024px) 25vw, 50vw') ?>
          </div>
        </div>
      </a>
    </li>
  <?php endforeach; ?>
</ul>