<?php

use Kirby\Data\Yaml;
use CFC\Payment\StripeClient;
use CFC\Payment\Cart;
use CFC\Payment\Reduction;

class FormSubmissionPage extends Page
{

    protected $stripe = null;

    public function updateFromStep(FormStepPage $step, $data)
    {


        $old = [];
        $picture = null;
        $cart = null;
        $save = [];


        foreach ($this->data()->toStructure() as $item) {
            $old[$item->name()->value()] = $item->value()->value();
        }

        $new = [];
        foreach ($step->getHandlers() as $handler) {
            $handlerData = $handler->merge($data, $this);
            $picture = $handlerData['picture'] ?? $picture;
            $cart = $handlerData['cart'] ?? $cart;
            $new = array_merge($new, $handlerData['data']);
        }


        $new = array_merge($old, $new);

        if (!isset($new['product__id']) && $product =  $this->parent()->parent()->default_product()->toPage()) {
            $new['product__id'] = $product->uuid()->id();
            if (!isset($cart) && $this->cart()->isEmpty()) {
                $cart = Cart::fromProductId($product->uuid()->id());
                $cart = $cart->toKirbyObject();
            }
        }

        if (isset($new['product__id']) && $product = page('page://' . $new['product__id'])) {
            $new['product__name'] = $product->_display_name();
        }
        $struct = [];
        foreach ($new as $key => $value) {
            $struct[] = ['name' => $key, 'value' => $value];
        }

        $save['data'] = Yaml::encode($struct);

        if ($this->shouldUpdateStep($step)) {
            $save['step'] = (string)$step->uuid();
            $save['step_number'] = $step->num() - 1;
        }

        if (isset($picture)) {
            $save['picture'] = $picture;
        }

        if (isset($cart)) {
            $save['cart'] = $cart;
        }



        if (isset($data['contact__first_name']) && isset($data['contact__last_name'])) {
            $thisPage =  $this->changeTitle($data['contact__first_name'] . ' ' . $data['contact__last_name']);
        } else {
            $thisPage = $this;
        }

        $thisPage->update($save);
    }

    public function _data()
    {
        $data = [];
        foreach ($this->data()->toStructure() as $item) {
            $data[$item->name()->value()] = $item->value()->value();
        }
        return $data;
    }

    public function hasProduct($productId)
    {
        $data = $this->_data();
        return isset($data['product__id']) && $data['product__id'] === $productId;
    }



    protected function reformatDate($dateString)
    {

        $dateObject = DateTime::createFromFormat('Y-m-d', trim($dateString));

        if ($dateObject && $dateObject->format('Y-m-d') === $dateString) {
            return $dateObject->format('d.m.Y');
        }

        return $dateString;
    }
    public function _grouped_data()
    {
        $allFields = $this->parent()->parent()->getAllFields();
        $fieldMap = [];
        foreach ($allFields as $field) {
            $fieldMap[$field['name']] = $field['label'] ?? $field['name'];
        }
        $data = $this->_data();
        $result = [];
        foreach ($data as $key => $value) {
            $parts = explode('__', $key, 2);
            $prefix = $parts[0];
            $actualKey = $parts[1];
            if (!isset($result[$prefix])) {
                $result[$prefix] = [];
            }
            $value = $this->reformatDate($value);
            $label = $fieldMap[$key] ?? $key;
            $result[$prefix][] = ['key' => $key, 'id' => $actualKey, 'value' => $value, 'label' => $label];
        }

        $response = [];
        foreach ($result as $key => $value) {
            $label = ucfirst($key);
            if ($key === 'jam_session') {
                $label = 'Jam Session';
            }
            $response[] = ['id' => $key, 'label' => $label, 'fields' => $value];
        }
        return $response;
    }

    protected function shouldUpdateStep($step)
    {
        if ($this->step()->isEmpty()) {
            return true;
        }

        return $this->step()->toPage()->num() < $step->num();
    }

    public function _stripe_attributes()
    {
        $intent = $this->_payment_intent();
        $attributes = [
            sprintf('data-stripe-key="%s",', $this->getStripeClient()->getPublicKey()),
            sprintf('data-intent-id="%s",', $intent->id),
            sprintf('data-intent-secret="%s",', $intent->client_secret),
        ];

        return implode(' ', $attributes);
    }

    public function _payment_intent()
    {
        if ($this->stripe_id()->isEmpty()) {
            $intent = $this->createPaymentIntent();
            $this->update(['stripe_id' => $intent->id]);
            return $intent;
        } else {
            $intent = $this->retrievePaymentIntent();
            return $intent;
        }
    }

    public function getCart()
    {
        if ($this->cart()->isEmpty()) {
            throw new \Exception('Cart not found');
        }

        $object = $this->cart()->toObject();
        return Cart::fromKirbyObject($object);
    }

    public function applyReduction($code)
    {
        $reduction = Reduction::fromCode($code);
        $cart = $this->getCart();
        $cart = $cart->applyReduction($reduction);
        $submission = $this->update(['cart' => $cart->toKirbyObject()]);

        $stripe = $this->getStripeClient();
        $intent = $this->retrievePaymentIntent();
        $intent = $stripe->updateIntent($intent->id, $cart);


        return $submission;
    }

    protected function getStripeClient()
    {
        if ($this->stripe === null) {
            $this->stripe = new StripeClient($this->parent()->parent()->test_payment_mode()->isTrue());
        }
        return $this->stripe;
    }

    protected function createPaymentIntent()
    {
        $cart = $this->getCart();
        try {
            $intent = $this->getStripeClient()->createIntent($cart);
        } catch (\Exception $e) {
            throw new \Exception('Could not create payment intent');
        }
        return $intent;
    }

    public function isCompleted()
    {
        if ($step = $this->step()->_page()) {
            $form = $step->parent();
            $total = $form->getStepCount();
            return $step->num() === $total - 1;
        }
        return false;
    }

    protected function retrievePaymentIntent()
    {
        $intentId = $this->stripe_id()->value();
        try {
            $intent = $this->getStripeClient()->retrieveIntent($intentId);
        } catch (\Exception $e) {
            throw new \Exception('Could not retrieve payment intent');
        }
        return $intent;
    }
}
