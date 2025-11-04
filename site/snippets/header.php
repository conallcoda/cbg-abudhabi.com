<?php

$desktopImage = $site->mountains_desktop();
$mobileImage = $site->mountains_mobile();
$title = $page->display_title();

?>

<header class="relative flex flex-col justify-end overflow-hidden bg-black h-[14rem] md:h-[24rem]">
    <div class="absolute bg-black top-[4rem] md:top-[6rem] left-0 bottom-0 right-0 w-full">
        <?= $desktopImage->_img('full-width', 'object-cover object-left-top h-[24rem] opacity-70 w-full hidden md:block') ?>
        <?= $mobileImage->_img('full-width', 'object-cover object-left-top h-[14rem] opacity-70 md:hidden') ?>
    </div>
    <div class="relative z-10 contained">
        <div class="mb-8 md:mb-20">
            <h1 class="text-white text-[2rem] md:text-[3rem] font-brown_bold"><?= $title ?></h1>
        </div>
    </div>
</header>