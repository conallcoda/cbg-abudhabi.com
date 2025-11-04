<?php

if (isset($block)) {
  $source = $block->source()->toPage();
}

if (!$source) {
  return;
}

$days = $source->getGalleriesByDay();

if (empty($days)) {
  return;
}
$activeDay = get('day') ? (int)get('day') : 1;




?>

<div class="event-galleries my-8" data-controller="tabs">
  <?php if (count($days) > 1) : ?>
    <div class="button-toggles mb-16">
      <?php $i = 1;
      foreach ($days as $day) :
      ?>
        <a data-tab-toggle-id="day_<?= $i ?>" data-action="tabs#toggle" class="tab-toggle button <?= $activeDay === $i ? 'active' : '' ?>"><?= $day['title'] ?></a>
      <?php
        $i++;
      endforeach; ?>
    </div>
  <?php endif; ?>
  <?php $i = 1;
  foreach ($days as $day) : ?>
    <div data-tab-item-id="day_<?= $i ?>" class="tab-item day <?= $activeDay === $i ? 'active' : '' ?>">
      <?php snippet('blocks/image_gallery', ['images' => $day['items']]); ?>
    </div>
  <?php $i++;
  endforeach; ?>
</div>