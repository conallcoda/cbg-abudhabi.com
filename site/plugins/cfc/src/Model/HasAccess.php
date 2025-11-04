<?php

namespace CFC\Model;

trait HasAccess
{
    public function getAccess()
    {
        if (!$this->restrict_access()->isTrue()) {
            return true;
        }

        $accessToken = get('t');
        if ($accessToken && $accessToken === $this->access_token()->value()) {
            return true;
        } else {
            return [
                'error' => [
                    'code' => 'EIAT',
                    'title' => 'Error',
                    'message' => 'You do not have access to view this page. [EIAT]',
                ],
            ];
        }
    }

    public function _preview_url()
    {
        $url = $this->url();
        if ($this->restrict_access()->isTrue()) {
            $url .= '?t=' . $this->access_token()->value();
        }
        return $url;
    }

    public function getLiveLayoutField()
    {
        if (!site()->isOnSeason() && $this->layout_off()->isNotEmpty()) {
            return $this->layout_off();
        } else {
            return $this->layout();
        }
    }

    public function getLayoutField()
    {
        $user = kirby()->user();
        $session = kirby()->session();
        if (!$user || !$session->get('cfc.season')) {
            return $this->getLiveLayoutField();
        }

        if ($session->get('cfc.season') === 'off' && $this->layout_off()->isNotEmpty()) {
            return $this->layout_off();
        } else {
            return $this->layout();
        }
    }
}
