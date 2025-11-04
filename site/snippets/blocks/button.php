<?php
$link = $block->link();
$text = $block->text()->value();
$newTab = $block->new_window()->isTrue();

$buttonClasses = match ($block->color()->value()) {
    '#ffffff' => 'white',
    '#f1cc0e' => 'gold',
    default => 'black'
};


$alignmentClasses = match ($block->align()->value()) {
    'start' => 'justify-start',
    'end' => 'justify-end',
    default => 'justify-center'
};

if ($buttonClasses === 'gold') {
    $buttonClasses = 'bg-gold hover:bg-goldHover text-black py-3 px-6 font-bold uppercase cursor-pointer outline-none border-none rounded-3xl text-xs no-underline';
} else {
    $buttonClasses = 'button ' . $buttonClasses;
}


?>
<div class="mt-12 md:mt-12 flex <?= $alignmentClasses ?>">

    <?= $link->_link($text,  $buttonClasses, $newTab) ?>

</div>