<?php

return [
    'mixins' => [
        'parent',
    ],
    'props' => [
        'label' => function () {
            return 'Submission';
        },
        'submission' => function () {

            $parent = $this->parentModel();
            if (!$parent) {
                return [];
            }
            return $parent->_grouped_data();
        }
    ]
];
