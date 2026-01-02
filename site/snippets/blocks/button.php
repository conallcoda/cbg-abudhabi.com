<?php
$text = $block->text()->value();
$url = $block->link()->toUrl();
$newTab = $block->new_window()->isTrue();

$theme = match (strtolower($block->color()->value())) {
    '#fd993c' => 'gold',
    '#fdebdd' => 'sand',
    '#000000' => 'black',
    '#efefef' => 'grey',
    '#ffffff' => 'white',
    default => 'sand'
};

$alignmentClasses = match ($block->align()->value()) {
    'start' => 'justify-start',
    'end' => 'justify-end',
    default => 'justify-center'
};
?>
<div class="mt-12 md:mt-12 flex <?= $alignmentClasses ?>">
    <?php snippet('button', [
        'text' => $text,
        'url' => $url,
        'theme' => $theme,
        'newTab' => $newTab
    ]) ?>
</div>