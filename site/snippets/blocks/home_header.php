<?php

$siteLogo = $site->site_logo_large();
$imageDesktop = $block->image_desktop()->toFile();
$imageMobile = $block->image_mobile()->toFile();

$now = new DateTimeImmutable();

if ($block->countdown_date()->isNotEmpty() && $block->countdown_time()->isNotEmpty()) {

    $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', sprintf('%s %s', $block->countdown_date(), $block->countdown_time()));
    $countdown = $start->diff($now);
    $countdownSeconds = $start->getTimestamp();
    $countdownSections = [
        'days' => $countdown->format('%a'),
        'hours' => $countdown->format('%i'),
        'minutes' => $countdown->format('%H'),
        'seconds' => $countdown->format('%s'),
    ];
}
$session = $kirby->session();
$timePartnerImage = $page->time_partner_image()->toFile();

?>
<div class="header-home min-h-screen flex flex-col relative pt-[6rem]" data-nav-target="hero">
    <div class="media overflow-hidden absolute-fill h-screen w-full">
        <div class="overlay absolute-fill h-screen bg-black opacity-20"></div>
        <?php if ($imageDesktop || $imageMobile) : ?>
            <?php if ($imageMobile) : ?>
                <?= $imageMobile->_img('full-width', 'absolute-fill w-full h-full object-cover md:hidden') ?>

            <?php endif; ?>
            <?php if ($imageDesktop) : ?>
                <?= $imageDesktop->_img('full-width', 'absolute-fill w-full h-full object-cover hidden md:block') ?>

            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="relative z-10 w-full  flex flex-[1] flex-col">
        <div></div>
        <div class="flex-[1] items-center flex-col flex justify-center">
            <?= $siteLogo->_img('full-width', 'w-[50vw] landscape:w-[17vw]', '(screen and (orientation: landscape)) 17vw, 50vw') ?>
            <?php if ($image = $block->presented_partner_image()->toFile()) : ?>
                <div class="text-center flex justify-center items-center mt-4 mb-6 md:mt-8 md:mb-12">
                    <div class="text-white  px-2 text-xs"><?= $block->presented_partner_label() ?></div>
                    <div>
                        <a href="<?= $block->presented_partner_url() ?>" target="_blank" rel="noreferrer">
                            <img class="w-16 landscape:w-20" alt="<?= $block->presented_partner_name() ?>" title="<?= $page->presented_partner_name() ?>" src="<?= $image->url() ?>">
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($block->date_text()->isNotEmpty()) : ?>
                <div class="opacity-70 font-brown_bold text-sm text-white mt-1 mb-3 md:hidden">
                    <?= $block->date_text()->kti() ?>
                </div>
            <?php endif; ?>
            <?php if ($block->intro_cta_text()->isNotEmpty() && $block->intro_cta_url()->isNotEmpty()) : ?>
                <?php if ($block->intro_cta_intro()->isNotEmpty()) : ?>
                    <div class="mt-8 mb-8 text-center px-4  text-white/75"><?= $block->intro_cta_intro()->kti() ?></div>
                <?php endif; ?>
                <div class="my-4">
                    <?php snippet('apply-button', ['url' => $block->intro_cta_url()->value(), 'text' => $block->intro_cta_text()->value()]) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="contained-xl pb-[2.5vh] md:pb-[5vh] md:flex md:flex-row md:items-end">
            <div>
                <?php if ($block->date_text()->isNotEmpty()) : ?>
                    <div class="text-white font-brown_bold  text-[1.5rem] text-white/75 hidden md:block">
                        <?= $block->date_text()->kti() ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="flex-[1]"></div>
            <div>
                <?php if ($timeKeepingImage = $block->timekeeping_partner_image()->toFile()) : ?>
                    <div class="pb-4 flex justify-center items-center">
                        <div class="text-white pr-4 text-sm text-white/75"><?= $block->timekeeping_partner_label() ?></div>
                        <div><a href="<?= $block->timekeeping_partner_url() ?>" target="_blank" title="<?= $page->timekeeping_partner_name() ?>"> <img alt="<?= $page->timekeeping_partner_name() ?>" class="w-20 h-auto" src="<?= $timeKeepingImage->url() ?>" /> </a></div>

                    </div>
                <?php endif; ?>
                <?php if (isset($countdownSeconds) && isset($countdownSections)) : ?>
                    <ul class="flex  text-white w-full" data-controller="countdown" data-seconds="<?= $countdownSeconds ?>">
                        <?php foreach ($countdownSections as $section => $value) : ?>
                            <li class="md:flex-[1] md:flex-initial uppercase min-w-20">
                                <div class="text-white/75 text-center md:text-right font-brown_bold text-[2rem] md:text-[3rem]" data-countdown-target="<?= $section ?>"><?= $value ?></div>
                                <div class="text-white/75 text-center md:text-right text-[0.6rem] md:text-[0.7rem] leading-[2px]"><?= $section ?></div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="bg-black relative py-8 md:py-16 w-full text-white">

    <div class="contained py-4 md:py-8  md:flex  justify-end items-end">
        <div class="font-brown text-gold text-[2.5rem] md:text-[3rem] md:flex-[0_0_50%] leading-snug">
            <?= $block->intro_title()->kti() ?>
        </div>
        <div class="right leading-snug leading-6 text-white/70  md:pb-4 pt-8 md:pt-0">
            <?= $block->intro_text()->kti() ?>
        </div>
    </div>
</div>