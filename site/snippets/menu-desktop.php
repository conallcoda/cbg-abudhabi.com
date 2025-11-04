<?php

$menu = $site->getActiveMenu();



?>


<div class="hidden md:flex items-center justify-center">
    <ul class="flex pr-10 items-center justify-center">
        <?php foreach ($menu as $item) : ?>
            <?php

            $newTab = $item->new_window()->isTrue();
            $hasSublinks = $item->sublinks()->isNotEmpty();

            ?>
            <li class="group pl-8 first:pl-0 text-xs uppercase leading-none relative max-w-[1500px]">
                <?= $item->link()->_link($item->text()->value(), 'cursor-pointer text-white opacity-70 hover:opacity-100m', $newTab) ?>
                <?php if ($hasSublinks) : ?>
                    <div class="hidden pt-2 group-hover:block hover:block whitespace-nowrap  absolute left-0">
                        <ul class="bg-white border shadow py-2 ">
                            <?php foreach ($item->sublinks()->toStructure() as $subItem) : ?>
                                <li class="leading-none py-2 px-4">

                                    <?= $subItem->link()->_link($subItem->text()->value(), 'text-black') ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </li>
        <?php endforeach ?>
    </ul>
    <?php if ($site->showApplyButton()) : ?>
        <div class="py-1 relative -translate-y-[0.2rem]">
            <?php snippet('apply-button') ?>
        </div>
    <?php endif; ?>
</div>