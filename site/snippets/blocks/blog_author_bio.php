<?php

if (isset($block)) {
  $author = $block->author()->_page();
}

$author = $author ?? null;

?>

<?php if ($page) : ?>
  <?php snippet('blocks/wrapped_media', [
    'blockId' => $block->custom_id()->or('b' . $block->id()),
    'mediaWidth' => 20,
    'image' => $author->profile_picture(),
    'text' => $author->bio()->kt(),
  ]);
  ?>
<?php endif; ?>
