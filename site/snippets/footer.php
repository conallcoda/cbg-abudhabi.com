<?php

$desktopImage = $site->mountains_desktop();
$mobileImage = $site->mountains_mobile();

$social = [
    'twitter' => 'ri-twitter-x-fill',
    'linkedin' => 'ri-linkedin-fill',
    'instagram' => 'ri-instagram-line',
    'youtube' => 'ri-youtube-fill',
];

$socialItems = [];
foreach ($social as $key => $value) {
    if ($site->$key()->isNotEmpty()) {
        $socialItems[$key] = [
            'icon' => $value,
            'url' => $site->$key()->value(),
        ];
    }
}


?>
<div class="relative overflow-x-hidden bg-black text-white w-full flex flex-col items-center">
    <div class="contained">
        <div class="flex justify-center h-32 my-8 md:my-16 md:h-40">
            <div class="flex border-l border-white"></div>
            <div class="flex border-r border-white"></div>
        </div>
        <div class="inline-flex w-full justify-center items-center flex-row">
            <?php foreach ($social as $key => $icon) : ?>
                <?php
                $url = $site->$key()->value();
                if (!$url)       continue;
                ?>

                <a href="<?= $url ?>" target="_blank" class="ml-4 md:ml-8 first:ml-0 text-xl leading-none p-2 flex items-center justify-center rounded-full bg-white text-black">
                    <i class="<?= $icon ?>"></i>
                </a>



            <?php endforeach; ?>
        </div>
        <div class="leading-loose my-16 text-xs text-center">
            Copyright © <?= (new DateTime())->format('Y') ?> cfcstmoritz <br />
            All rights reserved
        </div>
        <ul class="my-16 md:flex w-full flex-wrap justify-center md:px-24">
            <?php foreach ($site->footer_menu()->toStructure() as $item) : ?>
                <li class="my-4 md:my-0 text-center grow">
                    <?= $item->link()->_link($item->text()->value(), 'text-gold uppercase text-xs') ?>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
    <div>
        <?= $desktopImage->_img('full-width', 'hidden md:block') ?>
        <?= $mobileImage->_img('full-width', 'md:hidden') ?>

    </div>
</div>