<?php

return function () {
    if ($this->header_title()->isNotEmpty()) {
        return (string)$this->header_title();
    }

    if (in_array((string)$this->template(), ['article'])) {
        return (string)$this->parent()->title();
    }
    return (string)$this->title();
};
