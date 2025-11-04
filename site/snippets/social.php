<?php

$social = [
    'twitter' => 'ri-twitter-x-fill',
    'linkedin' => 'ri-linkedin-fill',
];


if (!isset($items)) {
    $items = [];
    foreach ($social as $name => $icon) {
        if ($item->$name()->isNotEmpty()) {
            $items[$name] = $item->$name()->value();
        }
    }
}

$items = isset($items) ? $items : [];
?>
<?php foreach ($items as $name => $url) : ?>
    <?php
    $icon = $social[$name] ?? null;
    if (!$icon) continue;
    ?>
    <a class="inline-block bg-black p-1 ml- first:ml-0 text-white hover:text-gold" target="_blank" rel="noopener noreferrer" href="<?= $url ?>">
        <i class="<?= $icon ?>"></i>
    </a>
<?php endforeach; ?>