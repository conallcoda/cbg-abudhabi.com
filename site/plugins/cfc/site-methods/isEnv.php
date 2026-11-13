<?php

return function ($value) {
    return strtolower(trim((string) option('app.env', 'production'))) === strtolower(trim((string) $value));
};
