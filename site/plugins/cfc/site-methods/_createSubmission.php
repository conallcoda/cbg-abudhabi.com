<?php

use Kirby\Database\Db;
use Kirby\Uuid\Uuid;

return function ($data = []) {
    $uuid = Uuid::generate();
    $result = Db::insert('submission', [
        'uuid' => $uuid,
        'access_token' => Uuid::generate(),
        'data' => json_encode($data)
    ]);
    return $result;
};
