<?php

return function () {
    $template = (string)$this->template();
    $template = $template === 'default' ? 'page' : $template;
    return ucfirst($template);
};
