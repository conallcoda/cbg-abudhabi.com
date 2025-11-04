<?php

$hooks = include __DIR__ . '/hooks.php';
$thumbs = include __DIR__ . '/thumbs.php';
$routes = include __DIR__ . '/routes.php';

$config = [
    'debug' => true,
    'markdown' => [
        'extra' => true
    ],
    'api' => [
        'allowInsecure' => false
    ],
    'cache' => [
        'cfc' => true
    ],
    'envs' => [
        'dev' => 'http://cfc.local',
        'staging' => 'https://staging.cfc-stmoritz.com',
        'production' => 'https://cfc-stmoritz.com',
    ],
    'mailgun_domain' => 'reservations.crypto-finance-conference.com',
    'mailgun_domain_mailer' => 'mailer.cfc-stmoritz.com',
    'mailchimp_list_id' => 'f8155bd4e5',
    'cfc.email.from.name' => 'CfC St. Moritz',
    'cfc.email.from.email' => 'noreply@reservations.crypto-finance-conference.com',
    'cfc.email.from.email_mailer' => 'noreply@mailer.cfc-stmoritz.com',
];



$config = array_merge($config, $thumbs, $hooks, $routes);
return $config;
