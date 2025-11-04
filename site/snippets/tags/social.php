<?php
$social = [
    'twitter' => 'twitter',
    'x.com' => 'twitter',
    'linkedin' => 'linkedin',
];

$icon = null;
$items = [];
foreach ($urls as $url) {
    foreach ($social as $name => $item) {
        if (strpos($url, $name) !== false) {
            $items[$item] = $url;
            break;
        }
    }
}
?>
<div class="mt-4"><?php snippet('social', ['items' => $items]); ?></div>