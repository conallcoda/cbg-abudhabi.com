<?php

namespace CFC\Form;

use CFC\Payment\Cart;

class SelectProductHandler extends AbstractFormHandler
{
    public function getFields()
    {
        return [
            [
                'name' => 'product__id',
                'label' => 'Product ID',
                'required' => true,
            ]
        ];
    }


    public function merge($data, \FormSubmissionPage $submission)
    {
        $productId = $data['product__id'];
        $cart = Cart::fromProductId($productId);
        return [
            'cart' => $cart->toKirbyObject(),
            'data' => ['product__id' => $data['product__id']]
        ];
    }
}
