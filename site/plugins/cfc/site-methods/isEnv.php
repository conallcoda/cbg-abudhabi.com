<?php

return function ($value) {
    $value = trim(strtolower($value));
    $envs = option('envs');
    $targetHost = isset($envs[$value]) ? $envs[$value] : null;
    return !is_null($targetHost) && strpos($this->url(), $targetHost) === 0;
};
