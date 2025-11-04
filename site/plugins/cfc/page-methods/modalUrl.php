<?php

return function () {
    return sprintf('%s?modal=%s', $this->url(), md5($this->uuid()->id()));
};
