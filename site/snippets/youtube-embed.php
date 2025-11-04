<?php
$videoId = $videoId ?? null;
if (isset($url)) {
    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
    $videoId = isset($matches[1]) ? $matches[1] : null;
}
?>
<?php if (isset($videoId)) : ?>
    <div class="aspect-w-16 aspect-h-9"><iframe src="https://www.youtube.com/embed/<?= $videoId ?>" allowfullscreen frameborder="0" width="100%%"></iframe></div>
<?php endif; ?>