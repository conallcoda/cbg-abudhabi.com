<?php

declare(strict_types=1);

namespace Thathoff\Oauth;

use Kirby\Http\Response;

/**
 * Redirect helper used by thathoff/kirby-oauth.
 *
 * The application disables Kirby's global go() helper because Forge's Swoole
 * extension declares an incompatible function with the same name. Defining
 * the helper in the plugin namespace keeps OAuth redirects independent of the
 * global function.
 */
function go(string $url = '/', int $code = 302): never
{
    Response::go($url, $code);
}
