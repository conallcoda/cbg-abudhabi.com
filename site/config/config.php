<?php

// All environment-specific configuration comes from .env (see .env.example).
require_once __DIR__ . '/../plugins/kirby3-dotenv/global.php';

loadenv([
    'dir' => dirname(__DIR__, 2),
    'required' => [
        'APP_ENV',
        'APP_URL',
        'MAILCHIMP_API_KEY',
        'STRIPE_PUBLIC_KEY_LIVE',
        'STRIPE_PUBLIC_KEY_TEST',
        'STRIPE_SECRET_KEY_LIVE',
        'STRIPE_SECRET_KEY_TEST',
    ],
]);

// Only the live website belongs in search results: never the Panel or its API, and nothing on staging or local.
$requestPath = (string)parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if (PHP_SAPI !== 'cli' && !headers_sent()
    && (env('APP_ENV', 'production') !== 'production' || preg_match('#^/(panel|api)(/|$)#', $requestPath) === 1)) {
    header('X-Robots-Tag: noindex, nofollow');
}

$hooks = include __DIR__ . '/hooks.php';
$thumbs = include __DIR__ . '/thumbs.php';
$routes = include __DIR__ . '/routes.php';

$envBool = static function (string $key, bool $default): bool {
    $value = env($key, $default);

    if (is_bool($value)) {
        return $value;
    }

    return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default;
};

$appEnv = env('APP_ENV', 'production');

$mailMailer = strtolower(trim((string)env('MAIL_MAILER', 'mailgun')));

if (!in_array($mailMailer, ['mailgun', 'mailpit'], true)) {
    throw new RuntimeException('MAIL_MAILER must be either "mailgun" or "mailpit".');
}

// Local and staging mail must never reach real people: it is captured in Mailpit.
if (in_array($appEnv, ['local', 'staging'], true) && $mailMailer !== 'mailpit') {
    throw new RuntimeException(sprintf('MAIL_MAILER must be "mailpit" when APP_ENV=%s, so no email leaves this server.', $appEnv));
}

$mailgunApiKey = trim((string)env('MAILGUN_API_KEY', ''));

if ($mailMailer === 'mailgun' && $mailgunApiKey === '') {
    throw new RuntimeException('MAILGUN_API_KEY is required when MAIL_MAILER=mailgun.');
}

$mailpitUsername = trim((string)env('MAILPIT_USERNAME', ''));
$mailpitPassword = trim((string)env('MAILPIT_PASSWORD', ''));
$mailpitHost = trim((string)env('MAILPIT_HOST', '127.0.0.1'));
$mailpitPort = (int)env('MAILPIT_PORT', 1025);

if (($mailpitUsername === '') !== ($mailpitPassword === '')) {
    throw new RuntimeException('MAILPIT_USERNAME and MAILPIT_PASSWORD must either both be set or both be empty.');
}

if ($mailMailer === 'mailpit' && ($mailpitHost === '' || $mailpitPort < 1 || $mailpitPort > 65535)) {
    throw new RuntimeException('MAILPIT_HOST and a valid MAILPIT_PORT are required when MAIL_MAILER=mailpit.');
}

$emailConfig = [];

if ($mailMailer === 'mailpit') {
    $emailConfig['transport'] = [
        'type' => 'smtp',
        'host' => $mailpitHost,
        'port' => $mailpitPort,
        'security' => false,
        'auth' => $mailpitUsername !== '',
        'username' => $mailpitUsername !== '' ? $mailpitUsername : null,
        'password' => $mailpitPassword !== '' ? $mailpitPassword : null,
    ];
}

$config = [
    'url' => env('APP_URL'),
    'app.env' => $appEnv,
    // The debug page shows the request, session and server, so it is only ever on locally: APP_DEBUG is ignored
    // anywhere else.
    'debug' => $appEnv === 'local' && $envBool('APP_DEBUG', false),
    // Even locally it never shows the values of .env (keys, passwords) or the cookies, which hold the session.
    'whoops' => [
        'blocklist' => [
            '_ENV' => array_keys($_ENV),
            '_SERVER' => [...array_keys($_ENV), 'HTTP_COOKIE', 'HTTP_AUTHORIZATION', 'PHP_AUTH_PW'],
            '_COOKIE' => array_keys($_COOKIE),
        ],
    ],
    'panel.install' => $envBool('KIRBY_PANEL_INSTALL', false),
    // A coloured line naming the environment, for staff (assets/panel).
    'panel.css' => in_array($appEnv, ['local', 'staging', 'production'], true) ? 'assets/panel/environment-' . $appEnv . '.css' : false,
    // The Panel's tab icon in the same colour; the website keeps its own favicon.
    'panel.favicon' => in_array($appEnv, ['local', 'staging', 'production'], true) ? 'assets/panel/favicon-' . $appEnv . '.png' : null,
    'markdown' => [
        'extra' => true
    ],
    'api' => [
        'allowInsecure' => false
    ],
    'cache' => [
        'pages' => $envBool('KIRBY_CACHE_PAGES', true),
        'cfc' => true
    ],
    'email' => $emailConfig,
    'stripe_key_secret_test' => env('STRIPE_SECRET_KEY_TEST'),
    'stripe_key_public_test' => env('STRIPE_PUBLIC_KEY_TEST'),
    'stripe_key_secret_live' => env('STRIPE_SECRET_KEY_LIVE'),
    'stripe_key_public_live' => env('STRIPE_PUBLIC_KEY_LIVE'),
    'mailgun_key' => $mailgunApiKey,
    'mailgun_domain' => env('MAILGUN_DOMAIN', 'reservations.crypto-finance-conference.com'),
    'mailgun_domain_mailer' => env('MAILGUN_MAILER_DOMAIN', 'mailer.cfc-stmoritz.com'),
    'mailchimp_key' => env('MAILCHIMP_API_KEY'),
    'mailchimp_list_id' => env('MAILCHIMP_LIST_ID', 'a7fa7a784c'),
    'cfc.email.from.name' => env('MAIL_FROM_NAME', 'CfC St. Moritz Abu Dhabi'),
    'cfc.email.from.email' => env('MAIL_FROM_ADDRESS', 'noreply@reservations.crypto-finance-conference.com'),
    'cfc.email.from.email_mailer' => env('MAILER_FROM_ADDRESS', 'noreply@mailer.cfc-stmoritz.com'),
    'cfc.email.enabled' => $envBool('FORM_EMAIL_ENABLED', true),
    'cfc.email.override_to' => trim((string)env('FORM_EMAIL_OVERRIDE_TO', '')),
    'cfc.email.mailer' => $mailMailer,
];

$config = array_merge($config, $thumbs, $hooks, $routes);
return $config;
