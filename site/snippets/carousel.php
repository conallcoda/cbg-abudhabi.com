<?php
$items = $items ?? [];
$slidesToScroll = $slidesToScroll ?? 1;
$template = $template ?? 'carousel';
$config = [
    'slidesToScroll' => $slidesToScroll,
];

$config = base64_encode(json_encode($config));


?>

<div class="embla" data-controller="carousel" data-config="<?= $config ?>">
    <div class="embla__viewport">
        <div class="embla__container">

            <?php foreach ($items as $item) : ?>
                <div class="embla__slide">
                    <?php snippet('carousel/' . $template, ['item' => $item]) ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="embla__controls mt-4">
        <div class="embla__buttons">
            <div class="embla__button embla__button--left">
                <a class="cursor-pointer embla__button embla__button--prev text-[2rem] block relative -translate-x-[0.75rem]">
                    <i class="ri-arrow-left-wide-fill"></i>
                </a>
            </div>
            <div class="embla__dots"></div>
            <div class="embla__button embla__button--right">
                <a class="cursor-pointer embla__button embla__button--next text-[2rem]" type="button">
                    <i class="ri-arrow-right-wide-fill"></i>
                </a>
            </div>
        </div>
    </div>
</div>