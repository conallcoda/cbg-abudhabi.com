<?php

$url = $url ?? $item->url();


?>

<div class="flex-[1]">
    <div class="aspect-w-10 aspect-h-9">
        <?= $item->picture()->_img('card', '',  '(min-width: 1024px) 34vw, 50vw') ?>
    </div>
    <?php if ($beforeTitle = $slots->before_title()) : ?>
        <?= $beforeTitle ?>
    <?php endif ?>
    <h5 class="mt-4"><?= $item->title() ?></h5>
    <?php if ($afterTitle = $slots->after_title()) : ?>
        <?= $afterTitle ?>
    <?php endif ?>
</div>
<div>
    <div class="flex flex-col-reverse md:flex-row mt-4 md:mt-8 pb-4 md:items-center">
        <div class="flex-[1] mt-4 md:mt-0">
            <?php snippet('button', ['text' => $site->read_more_cta(), 'url' => $url]) ?>
        </div>
    </div>
</div>