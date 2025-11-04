<?php

namespace CFC\Model;

interface HasAfterDuplicateHook
{
    public function _afterDuplicate();
}
