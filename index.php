<?php

// Swoole defines a global go() function. Forge enables Swoole by default, so
// disable Kirby's conflicting helper and use Response::go() explicitly.
define('KIRBY_HELPER_GO', false);

require __DIR__ . '/kirby/bootstrap.php';

echo (new Kirby)->render();
