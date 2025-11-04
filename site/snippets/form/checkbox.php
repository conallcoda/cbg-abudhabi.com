<?php
date_default_timezone_set('Europe/Berlin');
$date = (new DateTime())->format('d.m.Y H:i:s');
$isChecked = isset($isChecked) ? $isChecked : false;
$isRequired = isset($isRequired) ? $isRequired : false;
$value = isset($value) ? $value : '';
$label = isset($label) ? $label : $name;

?>
<div class="input">
    <input class="form-input form-input-field" <?= $isChecked ? 'checked' : '' ?> type="checkbox" value="<?= $date ?>">
</div>
<div class="text">
    <?= $label ?>
</div>