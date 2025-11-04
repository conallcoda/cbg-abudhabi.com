<?php

return [
    'attr' => ['size'],
    'html' => function ($tag) {
        $url = $tag->value;
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
        $videoId = isset($matches[1]) ? $matches[1] : null;

        if ($videoId) {
            return sprintf('<div class="aspect-w-16 aspect-h-9"><iframe src="https://www.youtube.com/embed/%s" allowfullscreen frameborder="0" width="100%%"></iframe></div>', $videoId);
        } else {
            return 'Invalid YouTube URL';
        }
    }
];
