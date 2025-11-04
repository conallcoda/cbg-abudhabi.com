<?php
$placeholder = $placeholder ?? '';
$name = $name ?? '';
$value = $value ?? '';
$disabled = $disabled ?? false;
$classNames = $classNames ?? '';
$type = $type ?? 'text';
$attributes = '';
if ($type === 'date' && $name === 'flight__arrival_date') {
    $today = date('Y-m-d');
    $attributes = "min='$today'";
}
?>

<input type="<?= $type ?>" <?= $attributes ?> class="<?= $classNames ?> focus:[box-shadow:none] border-transparent focus:border-black bg-grey  w-full py-4" placeholder="<?= $placeholder ?>" value="<?= $value ?>" <?= $disabled ? 'disabled' : '' ?>>