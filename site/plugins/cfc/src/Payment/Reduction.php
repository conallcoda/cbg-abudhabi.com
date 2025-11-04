<?php

namespace CFC\Payment;


class Reduction
{

    protected function __construct(protected string $code, protected string $type, protected float $amount)
    {
        $this->code = $code;
        $this->type  = $type;
        $this->amount = $amount;
    }


    public function getCode()
    {
        return $this->code;
    }

    public function apply($subtotal)
    {
        $computedAmount = 0;
        if ($this->type === 'fixed') {
            $computedAmount = $this->amount > $subtotal ? $subtotal : $this->amount;
        } elseif ($this->type === 'percentage') {
            $computedAmount = $subtotal * ($this->amount / 100);
        } else {
            throw new \Exception(sprintf('Invalid reduction code type %s', $this->type));
        }

        return $computedAmount;
    }
    public static function fromCode($code)
    {
        $found = null;
        foreach (site()->payment_reduction_codes()->toStructure() as $item) {
            if ($item->code()->value() === $code) {
                $found = $item;
                break;
            }
        }

        if (!$found) {
            throw new \Exception(sprintf('Reduction code "%s" not found', $code));
        }

        $type = $item->type()->value();

        if ($type === 'fixed') {
            return self::fromFixed($item);
        } elseif ($type === 'percentage') {
            return self::fromPercentage($item);
        } else {
            throw new \Exception(sprintf('Invalid reduction code type: "%s"', $type));
        }
    }

    protected static function fromFixed($item)
    {
        if ($item->fixed_amount()->isEmpty()) {
            throw new \Exception('Reduction fixed amount is invalid');
        }
        return new self($item->code()->value(), 'fixed', (float)$item->fixed_amount()->value());
    }

    protected static function fromPercentage($item)
    {
        if ($item->percentage_amount()->isEmpty()) {
            throw new \Exception('Reduction percentage amount is invalid');
        }
        return new self($item->code()->value(), 'percentage', (float)$item->percentage_amount()->value());
    }
}
