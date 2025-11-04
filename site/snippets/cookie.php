<?php

?>

<div class="cookie-consent animated inverse fadeInUp" data-controller="cookie-consent">
    <div class="inner">
        <div class="left paragraph">
            <?= $site->cookie_text()->kirbytext() ?>
        </div>
        <div class="right">
            <a data-action="cookie-consent#ok" class="button black"><?= $site->cookie_cta() ?></a>
        </div>
    </div>
</div>