<?php

class AppPage extends Page
{
    public function _download_app_links_url()
    {
        return site()->url() . '/download-app-links/' . (string)$this->uuid()->id() . '.csv';
    }
}
