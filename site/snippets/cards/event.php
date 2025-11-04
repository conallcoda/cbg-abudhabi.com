<?php snippet('cards/default', ['item' => $item], slots: true); ?>
<?php slot('after_title') ?>
<div class=" text text-sm font-brown_bold text-darkGrey">
    <div><?= $item->date_text() ?></div>
    <div><?= $item->location() ?></div>
</div>
<?php endslot() ?>
<?php endsnippet(); ?>