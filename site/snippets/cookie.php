<?php

?>

<div class="cookie-consent animated inverse fadeInUp" data-controller="cookie-consent">
    <div class="inner">
        <div class="left paragraph">
            <?= $site->cookie_text()->kirbytext() ?>
        </div>
        <div class="right">
            <?php snippet('button', [
                'text' => $site->cookie_cta(),
                'theme' => 'sand',
                'action' => 'cookie-consent#ok'
            ]) ?>
        </div>
    </div>
</div>