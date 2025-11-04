<?php

$numDesktop = $section->accordian_columns_per_row_desktop()->isEmpty() ? 1 : (string)$section->accordian_columns_per_row_desktop();
$classDesktop = $numDesktop > 1 ? 'desktop desktop-' . $numDesktop : '';
$disableToggle = $section->accordian_disable_toggle()->isTrue();
$enableToggle = $section->accordian_disable_toggle()->isTrue() ? '' : 'enable-toggle';

$items = $section->accordian_items()->toStructure();
?>

<ul class="section-accordian reset <?= $enableToggle ?> <?= $classDesktop ?>" data-controller="accordian">
    <?php $i = 0;
    foreach ($items as $item) : ?>
        <li class="accordian-item" data-key="<?= $i ?>">
            <div class="top accordian-title">
                <div class="accordian-title-text" data-action="click->accordian#toggle" class="toggle" data-key="<?= $i ?>">
                    <?= $item->title() ?>
                </div>

                <div data-action="click->accordian#toggle" class="toggle" data-key="<?= $i ?>">
                    <?php if (!$disableToggle) : ?>
                        <img alt="open" class="open" src="/assets/img/down.png" />
                        <img alt="close" class="close" src="/assets/img/up.png" />
                    <?php endif; ?>
                </div>
            </div>

            <div class="accordian-content animated kirbytext">
                <?= $item->text()->kirbytext() ?>

            </div>

        </li>
    <?php $i++;
    endforeach; ?>
</ul>