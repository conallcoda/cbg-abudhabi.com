<?php

namespace CFC\Model;

interface HasAfterUpdateHook
{
    public function _afterUpdate($new, $old);
}
