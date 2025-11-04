<?php


$user = kirby()->user();

if (!$user) {
    return;
}

$session = $kirby->session();

if (get('season') && in_array(get('season'), ['on', 'off'])) {
    $session->set('cfc.season', get('season'));
}

$options = ['off', 'on'];
$currentSeason = $site->season()->value();
$activeSeason = $session->get('cfc.season') ? $session->get('cfc.season') : $currentSeason;

$_options = [['text' => sprintf('LIVE (%s)', strtoupper($currentSeason)), 'value' => $currentSeason]];
if ($currentSeason === 'off') {
    $_options[] = ['text' => 'ON', 'value' => 'on'];
} else {
    $_options[] = ['text' => 'OFF', 'value' => 'off'];
}

$urlPrefix = $_SERVER['REQUEST_URI'];
$urlPrefix = preg_replace('/([?&])season=[^&]*/', '$1', $urlPrefix);
$urlPrefix =  rtrim($urlPrefix, '?&');

if (strpos($urlPrefix, '?') === false) {
    $urlPrefix .= '?';
} else {
    $urlPrefix .= '&';
}
?>

<div class="fixed bg-black right-0 bottom-0 z-20  p-2">
    <?php foreach ($_options as $option) : ?>
        <?php
        $linkClass = $option['value'] === $activeSeason ? 'text-gold' : 'text-white hover:text-gold';
        ?>
        <a href="<?= sprintf('%sseason=%s', $urlPrefix, $option['value']) ?>" class="<?= $linkClass ?>"><?= $option['text'] ?></a>
    <?php endforeach; ?>

</div>