<?php

$sizeClass = match ($size) {
    'xs' => 'h-2',
    'small' => 'h-4',
    'large' => 'h-8 md:h-16',
    'xl' => 'h-16 md:24',
    default => 'h-4 md:h-16'
}
?>
<div class=" <?= $sizeClass ?>">

</div>