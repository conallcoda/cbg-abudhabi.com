<?php

return function () {
    return !in_array((string)$this->template(), ['home', 'article']);
};
