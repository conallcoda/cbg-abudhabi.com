<?php

return function ($key, $fallback = null) {
    $key = str_replace('.', '_', $key);
    $key = str_replace('-', '_', $key);
    $key = 't_' . $key;

    if (!$this->$key()->isEmpty()) {
        return (string)$this->$key();
    } else {
        $germanContent = $this->content('de')->data();
        return isset($germanContent[$key]) ? $germanContent[$key] : $fallback;
    }
};
