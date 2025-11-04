<?php


$result = $profiles = site()->find('profiles')->children()->template('profile');
$user = kirby()->user();

if (!$user) {
    return;
}

?>


<?php snippet('layout', slots: true) ?>

<div class="contained my-16">

    <?php foreach ($result as $profile): ?>
        <?php
        $companyLogo = $profile->logo();
        if ($companyLogo->isEmpty() || !$companyLogo->toFile()) {
            continue;
        }

        $dimensions = $companyLogo->toFile()->dimensions();
        $width = $dimensions->width();
        $height = $dimensions->height();
        $_ratio = $width / $height;
        ?>

        <div class="mt-8">
            <h3><?= $profile->title() ?> [<?= $width ?>x<?= $height ?>] [<?= $profile->_logo_ratio() ?>]</h3>
            <div>
                <?php snippet('company-logo', ['image' => $companyLogo]) ?>
            </div>
        </div>

    <?php endforeach; ?>

</div>
<?php endsnippet() ?>