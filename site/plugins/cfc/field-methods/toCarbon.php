<?php

use Carbon\Carbon;

return function ($field, $locale = null) {
    $value = (string)$field->value();
    if (empty($value)) {
        return null;
    }
    if (is_numeric($value)) {
        return Carbon::createFromTimestamp((int)$value);
    } else {
        return Carbon::parse($value);
    }
};
