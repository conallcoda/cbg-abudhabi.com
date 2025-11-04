<?php
return function () {
    if (!$this->parent()) {
        return $this->title();
    }
    return $this->parent->title() . ' → ' . $this->title();
};
