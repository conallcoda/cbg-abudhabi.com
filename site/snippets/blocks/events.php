<?php

$items = $block->items()->_pages();
?>

<?php snippet('cards/index', ['items' => $items]) ?>
