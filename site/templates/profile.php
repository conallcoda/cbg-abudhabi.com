<?php

$image = $page->picture();
$croppedImage = $page->picture_cropped();

if ($image->isEmpty()) {
    $image = $croppedImage;
}
$companyLogo = $page->logo();


?>

<?php snippet('layout', slots: true) ?>
<section id="modalContent" class="contained py-8 md:py-16">
    <div class="content">
        <div class="logo  mb-4">
            <?php if (!$page->company_url()->isEmpty()) : ?>
                <a href="<?= $page->company_url() ?>" target="_blank" rel="noreferrer">
                <?php endif; ?>
                <?php if ($companyLogo->isNotEmpty() && $companyLogoFile =  $companyLogo->toFile()) : ?>

                    <?php snippet('company-logo', ['image' => $page->logo()]) ?>
                <?php else : ?>
                    <div class="company title">
                        <?= $page->company() ?>
                    </div>
                <?php endif; ?>
                <?php if (!$page->company_url()->isEmpty()) : ?>
                </a>
            <?php endif; ?>
        </div>
        <?php if ($image->isNotEmpty()) : ?>
            <div class="w-1/2 md:w-1/4 ">
                <?= $image->_img('profile', 'grayscale md-hover:grayscale-0',  '(min-width: 1024px) 25vw, 50vw') ?>
            </div>
        <?php endif; ?>

        <h2 class="mt-4"><?= $page->title() ?></h2>
        <h3 class="mb-4"><?= $page->subtitle() ?></h3>
        <div class="mb-4">
            <?= $page->bio()->kirbytext() ?>
        </div>
        <?php if (!$page->email()->isEmpty()) : ?>
            <div class=" mb-4">
                <a class="text-darkGold font-brown_bold no-underline" href="mailto:<?= $page->email() ?>"><?= $page->email() ?></a>
            </div>
        <?php endif; ?>
        <?php snippet('social', ['item' => $page]) ?>
    </div>

</section>
<?php endsnippet() ?>