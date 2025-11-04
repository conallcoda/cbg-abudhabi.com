<?php

use Kirby\Toolkit\Str;

if (isset($block)) {
    $source = $block->source()->toPage();
}

$days = $source  ? $source->getEventsByDay() : [];
$toKey = function ($title) {
    $str =  Str::slug($title);
    $str = str_replace('-', '_', $str);
    return $str;
};

foreach ($days as $key => $dayContainer) {
    $firstDay = $toKey($key);
    break;
}


$activeDay = get('day') ? get('day') : $firstDay;
?>

<div class="agenda-list" data-controller="tabs">
    <?php if (count($days) > 1) : ?>
        <div class="button-toggles">
            <?php $i = 1;
            foreach ($days as $key => $dayContainer) :
                $id = $toKey($key);
                $day = $dayContainer[0];
            ?>
                <a data-tab-toggle-id="<?= $id ?>" data-action="tabs#toggle" class="tab-toggle button <?= $activeDay === $id ? 'active' : '' ?>"><?= $day['title'] ?></a>
                <div class="button-break break_<?= $id ?>"></div>
            <?php
                $i++;
            endforeach; ?>
        </div>
    <?php endif; ?>
    <?php $i = 1;
    foreach ($days as $key => $dayContainer) :
        $id = $toKey($key);
    ?>


        <div data-tab-item-id="<?= $id ?>" class="tab-item day <?= $activeDay === $id ? 'active' : '' ?>">
            <?php foreach ($dayContainer as $day):  ?>
                <h2 class="mb-0 mt-16"><?= $day['date_text'] ?> </h2>
                <h3><?= $day['subtitle'] ?></h3>
                <ul>
                    <?php foreach ($day['sessions'] as $session) : ?>
                        <?php snippet('blocks/divider') ?>
                        <li class="reset-list mt-6 pt-6 ">
                            <?php if (!empty($session['title']) && trim($session['title']) !== '&nbsp;') : ?>
                                <h3 class="mb-8"><?= $session['title'] ?></h4>
                                <?php endif; ?>
                                <ul>
                                    <?php foreach ($session['events'] as $event) : ?>
                                        <li class="md:flex mt-4 justify-center">
                                            <div class="flex-[0_0_8rem] font-brown_bold leading-[1.2]">
                                                <?= $event['time_range'] ?>
                                            </div>

                                            <div class="flex mt-4 md:mt-0 flex-[1]">
                                                <div class="yellow-dot"></div>
                                                <div class="flex-[1]">
                                                    <h4 class="mt-0 "> <?= $event['title'] ?></h4>
                                                    <?php if ($event['hide_speakers']) : ?>
                                                        <div class="font-brown_bold text-sm opacity-70 no-underline"><?= $site->speakers_placeholder() ?></div>
                                                    <?php elseif (count($event['speakers'])): ?>
                                                        <div class="speakers">
                                                            <ul class="flex flex-wrap md:gap-1">
                                                                <?php $j = 0;
                                                                foreach ($event['speakers'] as $speaker) : ?>
                                                                    <li>
                                                                        <a data-action="burger#openModal" class="font-brown_bold text-sm opacity-70 no-underline" href="<?= $speaker->url() ?>">
                                                                            <?= $speaker->title() ?><?= $j !== count($event['speakers']) - 1 ? ',' : '' ?>
                                                                        </a>
                                                                    </li>
                                                                <?php $j++;
                                                                endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php
                                                    if (!$event['hide_description'] && !empty($event['description'])) : ?>
                                                        <div class="mt-2 text-sm"><?= $event['description'] ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        </div>

    <?php $i++;
    endforeach; ?>

</div>