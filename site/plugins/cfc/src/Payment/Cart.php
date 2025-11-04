<?php

namespace CFC\Payment;

use Kirby\Data\Yaml;

class Cart
{
    protected Reduction|null $reduction;
    protected $products = [];
    protected $vat_rate;

    public function __construct(array $products, Reduction $reduction = null)
    {
        $this->vat_rate = site()->payment_vat_rate()->toFloat();
        $this->products = $products;
        $this->reduction = $reduction;
    }

    public function toArray()
    {
        $subtotal = 0;


        foreach ($this->products as $product) {
            $subtotal += $product['price'];
        }

        if ($this->reduction) {
            $reductionCode = $this->reduction->getCode();
            $reductionAmount = $this->reduction->apply($subtotal);
            $subtotal -= $reductionAmount;
        }

        $vat = $this->calculateVat($subtotal);
        $total = round($subtotal + $vat, 2);


        return [
            'products' => $this->products,
            'vat_rate' => $this->vat_rate,
            'subtotal' => $subtotal,
            'reduction_code' => $reductionCode ?? null,
            'reduction_amount' => $reductionAmount ?? null,
            'vat' => $vat,
            'total' => $total,
        ];
    }

    public function hasReduction()
    {

        return $this->reduction !== null;
    }

    public static function fromKirbyObject($object)
    {
        $products = [];
        foreach ($object->products()->toStructure() as $product) {
            $products[] = [
                'name' => $product->name()->value(),
                'price' => $product->price()->value(),
            ];
        }
        $reduction = null;
        if ($object->reduction_code()->isNotEmpty()) {
            try {
                $reduction = Reduction::fromCode($object->reduction_code()->value());
            } catch (\Exception $e) {
                $reduction = null;
            }
        }

        return new self($products, $reduction);
    }
    public function toKirbyObject()
    {
        return Yaml::encode($this->toArray());
    }

    protected function calculateVat($amount)
    {
        return $amount * ($this->vat_rate / 100);
    }

    public function toSummary()
    {
        $cart = $this->toArray();

        $summary = [
            ['text' => sprintf('Reduction (%s)', $cart['reduction_code']), 'amount' => $cart['reduction_amount'] * -1, 'className' => 'reduction'],
            ['text' => 'Subtotal', 'amount' => $cart['subtotal']],
            ['text' => sprintf('Vat (%s)', $cart['vat_rate'] . '%'), 'amount' => $cart['vat']],
            ['text' => 'Total', 'amount' => $cart['total'], 'className' => 'font-brown_bold']
        ];


        foreach ($cart['products'] as $product) {
            $products[] = ['text' => $product['name'], 'amount' => $product['price']];
        }

        $summary = array_merge($products, $summary);
        return $summary;
    }

    public function toSummaryHtml()
    {
        $summary = $this->toSummary();
        return snippet('payment-summary', ['summary' => $summary, 'hasReduction' => $this->reduction != null], true);
    }

    public function  applyReduction(Reduction $reduction)
    {
        return new self($this->products, $reduction);
    }


    public static function fromProductId($productId, Reduction $reduction = null)
    {
        $product = site()->find('products')->find('page://' . $productId);
        if (!$product) {
            throw new \Exception('Product not found');
        }
        $products = [[
            'name' => $product->_display_name(),
            'price' => $product->price()->toFloat(),
        ]];
        return new self($products, $reduction);
    }
}
