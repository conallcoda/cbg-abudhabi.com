<?php
$tags = $item->tags()->split();
?>
<?php snippet('cards/default', ['item' => $item], slots: true); ?>
<?php slot('before_title') ?>
<?php if (count($tags)) : ?>
    <ul class="flex flex-wrap gap-1 mt-2">
        <?php foreach ($tags as $tag) : ?>
            <li class="tag text-sm yellow py-1 px-2 font-brown_bold"><?= $tag ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php endslot() ?>
<?php slot('after_title') ?>
<div class=" text text-sm font-brown_bold text-darkGrey">
    <div><?= $item->date_text() ?></div>
</div>
<?php endslot() ?>
<?php endsnippet(); ?>