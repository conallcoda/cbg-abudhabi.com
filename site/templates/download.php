<?php

use Kirby\Toolkit\Str;

$file = $page->download_file()->toFile();


if (!$file) {
    die;
}

$filename = sprintf('%s-cfc-st-moritz.%s',  Str::slug($page->title()), $file->extension());


header('Content-Type: application/octet-stream');
header('Content-Transfer-Encoding: Binary');
header('Content-disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . filesize($file->root()));
header('Pragma: public');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
readfile($file->root());
exit;
