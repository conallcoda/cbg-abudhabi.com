<?php

use Kirby\Database\Db;

return function ($id) {
    $result = Db::first('submissions', '*', 'uuid like :id', ['id' => $id]);
    return $result;
};
