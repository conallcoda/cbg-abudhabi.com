<?php
$url = $url ?? '/apply';
$text = $text ?? $site->apply_cta()->value();

snippet('button', [
    'text' => $text,
    'url' => $url,
    'theme' => 'gold'
]);
?>