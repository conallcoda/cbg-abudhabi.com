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
        'dev' => 'http://cfc-abudhabi.local',
        'staging' => 'https://staging.cfc-abudhabi.local.com',
        'production' => 'https://cfc-abudhabi.com',
    ],
    'mailgun_domain' => 'reservations.crypto-finance-conference.com',
    'mailgun_domain_mailer' => 'mailer.cfc-stmoritz.com',
    'mailchimp_list_id' => 'a7fa7a784c',
    'cfc.email.from.name' => 'CfC Abu Dhabi',
    'cfc.email.from.email' => 'noreply@reservations.crypto-finance-conference.com',
    'cfc.email.from.email_mailer' => 'noreply@mailer.cfc-stmoritz.com',
];



$config = array_merge($config, $thumbs, $hooks, $routes);
return $config;
