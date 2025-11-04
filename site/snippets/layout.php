<?php

use CFC\Model\IsAccessible;

$siteTitle = $site->title()->html();
$title = $siteTitle . ' | ' . (string)$page->title();
$isMobileDevice = false;
$hasHeader = $page->has_header();
$socialImage = $site->social_share_image();
$socialImageUrl = $socialImage->toFile() ? $socialImage->toFile()->thumb(1000)->url() : '';
$description = $site->site_description();
$mainClasses = '';



if (!$page instanceof IsAccessible) {
    go('error');
    die;
}
$error = false;

if ($page instanceof IsAccessible) {
    $access = $page->getAccess();
    $error = $access === true ? false : $access['error'];
}
?>

<!doctype html>
<html lang="<?= $kirby->language() ? $kirby->language()->code() : 'en' ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $title ?></title>
    <link rel="shortcut icon" type="image/png" href="<?= Bnomei\Fingerprint::url('/assets/favicon.png') ?>" />
    <?= $page->headLinkAlternates(); ?>
    <meta name="author" content="<?= $site->title() ?>">
    <meta name="copyright" content="<?= $site->title() ?>">
    <meta name="description" content="<?= $description ?>">
    <meta property="og:url" content="<?= $page->url() ?>">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= $title ?>" />
    <meta property="og:site_name" content="<?= $site->title() ?>" />
    <meta property="og:description" content="<?= $description ?>" />
    <meta name="image" content="<?= $socialImageUrl ?>">
    <meta property="og:image" content="<?= $socialImageUrl ?>">
    <meta property="twitter:image" content="<?= $socialImageUrl ?>">

    <link rel="preload" href="<?= Bnomei\Fingerprint::url('/assets/dist/main.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <script defer type="text/javascript" src="<?= Bnomei\Fingerprint::url('/assets/dist/main.js') ?>"></script>
    <?php if ($site->isEnv('production')) : ?>
        <meta name="google-site-verification" content="hsXIeOA-qaLtHyNoZFz2QZavdFrA6SerkFYOBJJz3uE" />
        <?php snippet('analytics') ?>
    <?php endif; ?>
</head>

<body class="page_<?= $page->uuid()->id() ?> relative <?= $page->template() ?><?= $isMobileDevice ? ' touch' : '' ?>" data-controller="nav burger" data-template="<?= $page->template() ?>">

    <div class="flex flex-col min-h-[100vh]">
        <?php snippet('nav') ?>
        <?php if ($hasHeader) : ?>
            <?php snippet('header') ?>
        <?php endif; ?>
        <main class="min-h-screen <?= $mainClasses ?>">
            <?php if ($error): ?>
                <?php snippet('error', ['error' => $error]) ?>
            <?php elseif (!empty(trim($slot))) : ?>
                <?= $slot ?>
            <?php elseif ($page->layout()->isNotEmpty()) : ?>
                <?php snippet('grid', ['field' => $page->layout()]) ?>
            <?php endif; ?>
        </main>
        <footer>
            <?php snippet('footer') ?>
        </footer>
    </div>
    <?php snippet('cookie') ?>
</body>

</html>