<?php

if (file_exists(__DIR__ . '/production.php')) {
    return include(__DIR__ . '/production.php');
}
