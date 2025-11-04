<?php

class ProductPage extends Page
{

    public function _panel_title()
    {
        return sprintf('%s [%s]', $this->title(), $this->_price_text());
    }

    public function _product_code()
    {
        return (string)$this->slug();
    }
    public function _display_name()
    {
        if ($this->display_name()->isEmpty()) {
            return (string)$this->title();
        } else {
            return (string)$this->display_name();
        }
    }

    public function _price_text()
    {
        $rawValue = $this->price()->value();
        $formattedValue = number_format($rawValue, 2, '.', ',');
        return sprintf('CHF %s', $formattedValue);
    }

    public function _toCart() {}
}
