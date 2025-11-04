<?php

namespace CFC\Model;

interface HasBeforeUpdateHook
{
    public function _beforeUpdate($page, $input, $strings);
}
