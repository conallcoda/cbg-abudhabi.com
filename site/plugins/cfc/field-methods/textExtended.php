<?php

return function ($field) {
    $text = (string)$field->text();
    $text = str_replace('--', '&shy;', $text);
    return $text;
};
