<?php

use CFC\Util\StyleMapper;



$containerSize = $containerSize ?? 'contained';
$paddingTop = $paddingTop ?? 'pt-0 md:pt-0';
$paddingBottom = $paddingBottom ?? 'pb-0 md:pb-0';
$mainClasses = $mainClasses ?? '';
$i = 0;

$firstLayoutHasBackgroundColor = false;
foreach ($field->toLayouts() as $layout) {
    if ($i === 0 && $layout->background_color()->isNotEmpty()) {
        $firstLayoutHasBackgroundColor = true;
    }
    $i++;
}

if (empty($mainClasses) && !$page->isHomePage() && !$firstLayoutHasBackgroundColor) {
    $mainClasses .= 'pt-8 md:pt-16 pb-8 md:pb-16 ';
} elseif ($firstLayoutHasBackgroundColor) {
    $mainClasses .= 'pb-8 md:pb-16';
}

$mainClasses = $page->isHomePage() ? $mainClasses : $mainClasses . ' ';

?>

<div class="<?= $mainClasses ?>">
    <?php
    $i = 0;
    foreach ($field->toLayouts() as $layout) :

        $customClass = (string)$page->template() === 'form_step' ? 'no_padding' : '';

        $customClass = $layout->custom_class()->isNotEmpty() ? $layout->custom_class()->value() : $customClass;
        $customid = $layout->custom_id()->value();
        $defaults = [];
        $containerClass = '';

        if (strpos($customClass, 'no_padding') === false) {
            $defaults['padding_top'] = $paddingTop;
            $defaults['padding_bottom'] = $paddingBottom;
        }

        if (!$layout->full_width()->isTrue()) {
            $containerClass = $containerSize;
        }


        $classNames = StyleMapper::toClassNames($layout, $defaults);

        $horizontalalignmentClasses = match ($layout->align_horizontal()->value()) {
            'right' => 'text-right',
            'center' => 'text-center',
            default => 'text-left'
        };

        $classNames .= ' ' . $horizontalalignmentClasses;


    ?>
        <section class="group relative  <?= $customClass ?> <?= $classNames ?>" id="<?= esc($layout->id(), 'attr') ?>">
            <div class="md:flex  gap-8 <?= $containerClass ?> ">
                <?php $ci = 1;
                foreach ($layout->columns() as $column) :
                    $method = sprintf('column_width_%d', $ci);
                    $columnWidthStyle = $layout->$method()->isEmpty() ? '' :  sprintf('flex: 0 0 %s%%;', $layout->$method()->value());
                ?>
                    <div class="column columns-<?= $layout->columns()->count() ?> flex-[1]" style="<?= $columnWidthStyle ?>">
                        <?php foreach ($column->blocks() as $block) : ?>
                            <?php
                            $blockId = $block->custom_id()->or('b' . $block->id());
                            $blockClass = $block->custom_class()->value();

                            ?>
                            <div class="block block-type-<?= $block->type() ?> <?= $blockClass ?> " id="<?= esc($blockId, 'attr') ?>">
                                <?= $block ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                <?php $ci++;
                endforeach ?>
            </div>
        </section>
    <?php $i++;
    endforeach ?>
</div>