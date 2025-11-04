<?php

$menu = $site->getActiveMenu();


?>
<div class="drawer animate-fadeInLeft bg-black fixed left-0 w-full z-30 top-[4rem]  md:top-[6rem] h-[calc(100vh_-_4rem)] md:h-[calc(100vh_-_6rem)]" data-burger-target="nav">
    <div class="scroll menu  inverse flex flex-col h-screen" data-burger-target="menu">
        <div class="contained">
            <ul class="text-white">
                <?php foreach ($menu as $item) : ?>
                    <?php
                    $hasSublinks = $item->sublinks()->isNotEmpty();
                    $textSize = $hasSublinks ? 'text-[0.7rem] opacity-80 ' : 'text-sm font-brown_bold';

                    ?>
                    <li class="<?= $textSize ?> text-white uppercase py-6 border-b-2 border-white last:border-b-0 border-opacity-30">
                        <?= $item->link()->_link($item->text()->value(), '') ?>
                        <?php if ($hasSublinks) : ?>
                            <ul class="pt-2">
                                <?php foreach ($item->sublinks()->toStructure() as $subItem) : ?>
                                    <li class="text-white text-sm uppercase py-2">
                                        <?= $subItem->link()->_link($subItem->text()->value(), '') ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach ?>
            </ul>

            <?php if ($site->showApplyButton()) : ?>
                <div class="relative -translate-x-2">
                    <?php snippet('apply-button') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="scroll pb-24 h-screen overflow-y-scroll modal flex flex-col bg-white" data-burger-target="modal">
        <div class="close-corner absolute top-8 right-8">
            <a class="burger-toggle text-3xl text-black cursor-pointer" data-burger-target="navClose" data-action="burger#close">
                <i class="ri-close-large-line"></i>
            </a>
        </div>
        <div class="content contained small py-8" data-burger-target="modalContent"></div>
        <div class="w-full text-center mt-4 mb-8">
            <a class="button black" data-action="burger#close">close</a>
        </div>
    </div>
</div>