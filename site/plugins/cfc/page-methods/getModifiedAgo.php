<?php

return function () {
    return $this->modified_at()->toCarbon('en')->diffForHumans();
};
