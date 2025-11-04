<?php

if (isset($block)) {
    $display = (string)$block->display();
    $items = $block->items()->toStructure();
}

$display = $display ?? 'list';
$items = $items ?? [];

$listClass = '';
if ($display === 'table') {
    $listClass = 'block md:hidden';
}
?>

<div>

    <ul class="<?= $display === 'table' ? 'block md:hidden' : '' ?>">
        <?php foreach ($items as $item) : ?>
            <?php
            $type = (string)$item->type();
            ?>
            <li class="mt-2 first:mt-0">
                <div class="flex">
                    <div class="yellow-dot"></div>
                    <div>
                        <div class="font-brown_bold"> <?= $item->title() ?> </div>
                        <?php if ($type === 'link' && $item->link()->isNotEmpty()) : ?>
                            <div><a target="_blank" rel="nofollow nooopener" class="underline  text-[0.9rem]" href="<?= $item->link()->toUrl() ?>"><?= $item->description() ?> <i class="ri-external-link-line"></i></a></div>
                        <?php elseif ($type === 'file' && $file = $item->file()->toFile()) : ?>
                            <div><a target="_blank" rel="nofollow noopener" class="underline  text-[0.9rem]" href="<?= $file->url() ?>"><?= $item->description() ?> <i class="ri-download-2-line"></i></i></a></div>
                        <?php endif; ?>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php if ($display === 'table') : ?>
        <table class="hidden md:table table-auto">
            <tbody>
                <?php foreach ($items as $item) : ?>
                    <?php
                    $type = (string)$item->type();
                    ?>
                    <tr class="">
                        <td class="align-middle pt-2 first:pt-0">
                            <div class="mt-1 yellow-dot">
                        </td>
                        <td class="align-middle pt-2 font-brown_bold pr-8  text-[0.9rem]"><?= $item->title() ?></td>
                        <td class="align-middle pt-2">
                            <?php if ($type === 'link' && $item->link()->isNotEmpty()) : ?>
                                <div><a target="_blank" rel="nofollow nooopener" class="underline text-[0.9rem]" href="<?= $item->link()->toUrl() ?>"><?= $item->description() ?> <i class="ri-external-link-line"></i></a></div>
                            <?php elseif ($type === 'file' && $file = $item->file()->toFile()) : ?>
                                <div><a target="_blank" rel="nofollow noopener" class="underline text-[0.9rem]" href="<?= $file->url() ?>"><?= $item->description() ?> <i class="ri-download-2-line"></i></i></a></div>
                            <?php endif; ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>