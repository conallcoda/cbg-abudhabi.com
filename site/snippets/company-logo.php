<?php

$file = $image->toFile();

if (!$file) {
    return;
}


$dimensions = $file->dimensions();
$width = $dimensions->width();
$height = $dimensions->height();
$ratio = round($width / $height, 2);

$logoClasses = 'max-w-[60%] max-h-[2rem] w-auto';

if ($ratio < 2) {
    $logoClasses = 'max-w-[60%] max-h-[4rem] w-auto';
} elseif ($ratio < 3) {
    $logoClasses = 'max-w-[60%] max-h-[3rem] w-auto';
} elseif ($ratio > 10) {
    $logoClasses = 'max-w-[60%] max-h-[1rem] w-auto';
} elseif ($ratio > 5) {
    $logoClasses = 'max-w-[60%] max-h-[1.5rem] w-auto';
}
?>


<?= $image->_img('partner', $logoClasses,  '(min-width: 1024px) 25vw, 50vw') ?>