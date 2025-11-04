<?php

if (isset($block)) {
  $source = $block->source()->toPage();
}

$sections = [];
if ($source) {
  $i = 0;
  foreach ($source->partners()->toStructure() as $item) {
    $sections[] = [
      'title' => $item->title(),
      'classNames' => '',
      'items' => $item->partners()->_pages(),
    ];
    $i++;
  }
}




?>


<?php $i = 0;
foreach ($sections as $section) : ?>
  <?php
  if (empty($section['items'])) continue; ?>
  <div>
    <h2 class="<?= $section['classNames'] ?>"><?= $section['title'] ?></h2>
    <?php snippet('blocks/partners', ['items' => $section['items']]) ?>
    <?php
    if ($i < count($sections) - 1) : ?>
      <?php snippet('blocks/divider') ?>
    <?php endif; ?>
  </div>
<?php $i++;
endforeach; ?>