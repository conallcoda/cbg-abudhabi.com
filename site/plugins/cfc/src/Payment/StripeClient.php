<?php

namespace CFC\Payment;

use Kirby\Data\Yaml;

class StripeClient
{
    protected $client;

    protected $secretKey;
    protected $publicKey;

    public function __construct(protected bool $testMode = true)
    {
        $this->testMode = false;
        $this->secretKey = option('stripe_key_secret_' . ($testMode ? 'test' : 'live'));
        $this->publicKey = option('stripe_key_public_' . ($testMode ? 'test' : 'live'));
        \Stripe\Stripe::setApiKey($this->secretKey);
    }

    public function createIntent(Cart $cart)
    {
        $data = $cart->toArray();
        $intent = \Stripe\PaymentIntent::create([
            'amount' => $data['total'] * 100,
            'currency' => 'chf',
            'payment_method_types' => ['card'],
            'capture_method' => 'manual',
            'metadata' => [
                'cart' => json_encode($data)
            ]
        ]);
        return $intent;
    }


    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function retrieveIntent($id)
    {
        return \Stripe\PaymentIntent::retrieve($id);
    }

    public function updateIntent($id, Cart $cart)
    {
        $data = $cart->toArray();

        return \Stripe\PaymentIntent::update($id,      [
            'amount' => $data['total'] * 100,
            'metadata' => [
                'cart' => json_encode($data)
            ]
        ]);
    }
}
