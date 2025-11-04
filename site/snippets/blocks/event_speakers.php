<?php

if (isset($block)) {
  $source = $block->source()->toPage();
  $blockId = $block->id();
}

$blockId = $blockId ?? '';

$speakers  = $source->speakers()->_pages();
$workshops  = $source->workshops()->_pages();
$moderators = $source->moderators()->_pages();

$profileSections = [];
if ($speakers->count() > 0) {
  $profileSections[] = ['title' => (string)site()->speakers_title()->or('Speakers'), 'items' => $speakers];
}
if ($workshops->count() > 0) {
  $profileSections[] = ['title' => (string)site()->workshops_title()->or('Workshop Hosts'), 'items' => $workshops];
}
if ($moderators->count() > 0) {
  $profileSections[] = ['title' =>  (string)site()->moderators_title()->or('Moderators'), 'items' => $moderators];
}

?>


<?php $i = 0;
foreach ($profileSections as $section) : ?>
  <?php
  if ($section['items']->count() > 0) : ?>
    <div>
      <h2><?= $section['title'] ?></h2>
      <?php snippet('blocks/profiles', ['blockId' => strtolower($section['title']), 'items' => $section['items']]) ?>
      <?php
      if ($i < count($profileSections) - 1) : ?>
        <?php snippet('blocks/divider') ?>
      <?php endif; ?>
    </div>
  <?php endif; ?>
<?php $i++;
endforeach; ?>