<?php

use CFC\Model\IsAccessible;
use CFC\Model\HasAccess;

class ProfilesPage extends Page implements IsAccessible
{

    use HasAccess;
    public function childrenWithoutPicture()
    {
        $filter = function ($child) {
            return $child->picture()->isEmpty();
        };
        return $this->childrenAndDrafts()->template('profile')->filter($filter);
    }
}
