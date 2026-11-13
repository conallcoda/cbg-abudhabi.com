<?php

namespace CFC\Email;

use InvalidArgumentException;
use Mailgun\Mailgun;
use RuntimeException;

final class ConfiguredMailer
{
    public static function send(array $message): void
    {
        $mailer = strtolower(trim((string)option('cfc.email.mailer', 'mailgun')));

        if ($mailer === 'mailgun') {
            self::sendWithMailgun($message);

            return;
        }

        if ($mailer === 'mailpit') {
            self::sendWithKirby($message);

            return;
        }

        throw new RuntimeException(sprintf('Unsupported MAIL_MAILER value: %s', $mailer));
    }

    private static function sendWithMailgun(array $message): void
    {
        if (in_array(option('app.env'), ['local', 'staging'], true)) {
            throw new RuntimeException('Mailgun is not used when APP_ENV is local or staging; set MAIL_MAILER=mailpit.');
        }

        $apiKey = trim((string)option('mailgun_key', ''));
        $domain = trim((string)option('mailgun_domain_mailer', ''));

        if ($apiKey === '' || $domain === '') {
            throw new RuntimeException('Mailgun credentials are required when MAIL_MAILER=mailgun.');
        }

        $payload = [
            'from' => sprintf(
                '%s <%s>',
                option('cfc.email.from.name'),
                option('cfc.email.from.email_mailer'),
            ),
            'to' => $message['to'],
            'subject' => $message['subject'],
            'text' => $message['text'],
        ];

        foreach (['bcc', 'html'] as $optional) {
            if (!empty($message[$optional])) {
                $payload[$optional] = $message[$optional];
            }
        }

        $mailgun = Mailgun::create($apiKey, 'https://api.eu.mailgun.net');
        $mailgun->messages()->send($domain, $payload);
    }

    private static function sendWithKirby(array $message): void
    {
        $email = [
            'from' => (string)option('cfc.email.from.email_mailer'),
            'fromName' => (string)option('cfc.email.from.name'),
            'to' => self::recipients($message['to']),
            'subject' => $message['subject'],
            'body' => array_filter([
                'text' => $message['text'],
                'html' => $message['html'] ?? null,
            ], static fn(mixed $value): bool => $value !== null && $value !== ''),
        ];

        if (!empty($message['bcc'])) {
            $email['bcc'] = self::recipients($message['bcc']);
        }

        kirby()->email($email);
    }

    private static function recipients(string|array $recipients): array
    {
        if (is_array($recipients)) {
            return $recipients;
        }

        $addresses = array_values(array_filter(
            array_map('trim', preg_split('/[,;]/', $recipients) ?: []),
            static fn(string $address): bool => $address !== '',
        ));

        foreach ($addresses as $address) {
            if (filter_var($address, FILTER_VALIDATE_EMAIL) === false) {
                throw new InvalidArgumentException(sprintf('Invalid email recipient: %s', $address));
            }
        }

        return $addresses;
    }
}
