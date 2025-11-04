<?php

use CFC\Model\IsAccessible;
use CFC\Model\HasAccess;

class HomePage extends Page implements IsAccessible
{
    use HasAccess;
}
