<?php

use CFC\Model\IsAccessible;
use CFC\Model\HasAccess;
use CFC\Model\HasAfterCreateHook;
use Kirby\Uuid\Uuid;

class DefaultPage extends Page implements IsAccessible, HasAfterCreateHook
{
    use HasAccess;

    public function _afterCreate()
    {
        $this->update(['access_token' => Uuid::generate()]);
    }
}
