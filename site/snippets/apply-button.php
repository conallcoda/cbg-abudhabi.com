<?php

$url = $url ?? '/apply';
$text = $text ?? $site->apply_cta()->value();

?>

<a class="bg-gold hover:bg-goldHover text-black py-3 px-6 font-bold uppercase cursor-pointer outline-none border-none rounded-3xl text-xs no-underline " href="<?= $url ?>"><?= $text ?></a>