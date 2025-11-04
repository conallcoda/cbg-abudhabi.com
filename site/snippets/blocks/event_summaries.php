<?php

if (isset($block)) {
  $blockId = $block->id();
  $source = $block->source()->toPage();
} else {
  $source = $source ?? null;
  $blockId = $blockId ?? null;
}

if (!$source) {
  return;
}

$days = $source->getSummariesByDay();

if (empty($days)) {
  return;
}
$activeDay = get('day') ? (int)get('day') : 1;

$items = [];
foreach ($days as $day) {
  $items[] = array_merge($day, [
    'pagination' => [
      'limit' => 24,
      'id' => sprintf('%s_%s', $blockId, $day['id'])
    ]
  ]);
}






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
  foreach ($items as $day) : ?>
    <div data-tab-item-id="day_<?= $i ?>" class="tab-item day <?= $activeDay === $i ? 'active' : '' ?>">
      <?php snippet('cards/index', ['items' => $day['items']]) ?>
    </div>
  <?php $i++;
  endforeach; ?>
</div>