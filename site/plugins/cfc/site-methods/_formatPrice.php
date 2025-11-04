<?php

return function ($value, $currency = 'CHF') {
    $value = (float)(string)$value;
    $number = number_format($value, 2, ',', '.');
    return sprintf('%s %s', $currency, $number);
};
