<?php

return function () {
    $url = $this->url();
    $relativeUrl = parse_url($url, PHP_URL_PATH);
    $relativeUrl = empty($relativeUrl) ? $url : $relativeUrl;
    if ($this->restrict_access()->isTrue()) {
        $relativeUrl .= '?t=' . $this->access_token()->value();
    }
    return sprintf('<a href="%s" target="_blank">%s</a>', $relativeUrl, $relativeUrl);
};
