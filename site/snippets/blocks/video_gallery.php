<?php

if (isset($block)) {
  $items = [];
  foreach ($block->items()->toStructure() as $item) {
    $items[] = [
      'title' => $item->title()->value(),
      'subtitle' => $item->subtitle()->value(),
      'url' => $item->video_url()->value(),
    ];
  }
}

$items = $items ?? [];

?>

<div>
  <ul class="grid grid-cols-1 md:grid-cols-2 mt-4 gap-8">
    <?php foreach ($items as $item) : ?>
      <li>
        <?php if (isset($item['title'])) : ?>
          <h4 class="video-title mb-2"> <?= $item['title'] ?></h4>
        <?php endif; ?>
        <?php if (isset($item['subtitle'])) : ?>
          <h5 class="opacity-80 mb-2 text-[1rem] ">
            <?= $item['subtitle'] ?>
          </h5>
        <?php endif; ?>
        <?php if (isset($item['url'])) : ?>
          <div>
            <?php snippet('youtube-embed', ['url' => $item['url']]); ?>
          </div>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
</div>