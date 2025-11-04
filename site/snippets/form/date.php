<?php
$value = $value ?? '';
$placeholder = 'dd/mm/yyyy';
?>

<input type="text" placeholder="<?= $placeholder ?>" value="<?= $value ?>" class="focus:[box-shadow:none] border-transparent focus:border-black bg-grey  w-full py-4" readonly="readonly">