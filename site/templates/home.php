
<?php

$gridConfig = [
    'paddingTop' => 'pt-8 md:pt-16',
    'paddingBottom' => 'pb-8 md:pb-16',
    'mainClasses' => '',
];

?>
<?php snippet('layout', slots: true) ?>
<?php snippet('on_off') ?>
<?php snippet('grid', array_merge($gridConfig, ['field' => $page->getLayoutField()])) ?>
<?php endsnippet() ?>