<?php

return [
    'attr' => ['size', 'caption', 'align', 'alt', 'inline', 'zoom'],

    'html' => function ($tag) {
        $page = $tag->parent();
        $site = $page->site();
        $name = trim($tag->value);


        if ($file = $page->files()->find($name)) {
            $type = (string)$file->type();
            $isMedia = in_array($type, ['image', 'video']);

            $data = [
                'file' => $file,
                'tag' => $tag,
                'type' => $type,
                'alt' => $tag->alt,
                'caption' => $tag->caption,
                'size' => $tag->size,
                'align' => $tag->align,
                'inline' => $tag->inline,

            ];
            return $isMedia ? snippet('tags/media', $data, true) : '';
        }
    }

];
