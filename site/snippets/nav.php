<?php

$logo = $site->site_logo();
$menu = $site->getActiveMenu();
?>

<nav class="text-white z-30 fixed left-0 w-full" data-nav-target="navElement">
    <div class="underlay absolute-fill bg-black opacity-0" data-nav-target="underlay"></div>
    <div class="relative z-20 flex h-16 md:h-24 items-center justify-center contained-xl">
        <?php if ($logo->isNotEmpty()) : ?>
            <div class="logo w-12 md:w-20" data-nav-target="logo">
                <a href="/">
                    <?= $logo->_img() ?>
                </a>
            </div>
        <?php endif; ?>
        <div class="grow middle"></div>
        <div class="menu">
            <?= snippet('menu-desktop') ?>
            <div class="md:hidden">
                <a class="text-3xl navOpen active animate-flipInY" data-burger-target="navOpen" data-action="burger#open"><i class="ri-menu-line"></i></a>
                <a class="text-3xl navClose animate-flipInY" data-burger-target="navClose" data-action="burger#close"><i class="ri-close-large-line"></i></a>
            </div>
        </div>
    </div>
</nav>
<?php snippet('drawer') ?>