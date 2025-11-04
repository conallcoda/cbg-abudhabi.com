<?php

return [
    'attr' => ['target', 'text', 'style', 'align', 'popup'],
    'html' => function ($tag) {

        $data = [
            'target' => $tag->target ? $tag->target : '',
            'style' => $tag->style ? $tag->style : '',
            'text' => $tag->text ? $tag->text : '',
            'url' => $tag->value,
            'popup' => $tag->popup ? $tag->popup : ''
        ];

        foreach ($data as $key => $value) {
            $data[$key] = explode(',', $data[$key]);
        }

        $buttons = [];
        for ($i = 0; $i < count($data['url']); $i++) {
            $buttonData = [];
            foreach ($data as $key => $value) {
                $buttonData[$key] = isset($data[$key][$i]) ? $data[$key][$i] : '';
            }
            $buttons[] = $buttonData;
        }

        $align = $tag->align ? $tag->align : '';

        $data = [
            'buttons' => $buttons,
            'align' => $align
        ];


        return snippet('tags/button', $data, true);
    }
];