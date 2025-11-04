<?php

return function () {
    $currentPage = page();
    return isset($currentPage) && $this->uuid()->id() === $currentPage->uuid()->id();
};
