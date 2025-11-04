<?php

return function ($id) {
    $id = trim((string)$id);
    if (strpos($id, 'page://') === false) {
        $id = sprintf('page://%s', $id);
    }
    $found = $this->index(true)->find($id);
    return $found;
};
