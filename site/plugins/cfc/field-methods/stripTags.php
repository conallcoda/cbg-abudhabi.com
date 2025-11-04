<?php

return function($field) {
    return strip_tags((string)$field);
};