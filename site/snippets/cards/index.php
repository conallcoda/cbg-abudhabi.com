<?php


$gridSize = $gridSize ?? 'grid-cols-2 md:grid-cols-4';
$pagination = $pagination ?? [];

[
    'paginate' => $paginate,
    'controllerAttr' => $controllerAttr,
    'containerAttr' => $containerAttr,
    '_items' => $_items,
]
    = site()->_paginate($pagination, $items);


?>

<div <?= $controllerAttr ?>>
    <ul <?= $containerAttr ?> class="mt-8 grid items-stretch gap-2 <?= $gridSize ?>">
        <?php foreach ($_items as $item) : ?>
            <?php
            $template = (string)$item->template();
            $template = !empty($template) ? $template : 'default';
            ?>
            <li class="flex flex-col border border-lightGrey p-2">
                <?php snippet('cards/' . $template, ['item' => $item]); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php snippet('infinite-spinner', ['paginate' => $paginate]); ?>
</div>