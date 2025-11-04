<?php

$products = $block->items()->_pages();
$step = $block->parent();
$options = [];
$value = $step->parent()->getExistingValueFor('product__id');

foreach ($products as $product) {
    $defaultText = $product->_display_name();
    $buttonText = $product->button_text()->or($defaultText);
    $productText = sprintf('%s - %s', $buttonText, $product->_price_text());
    $options[$product->uuid()->id()] = $productText;
}


?>
<form name="product" class="mt-4" data-handler="form-fields">
    <div data-field-type="survey_radio_boxes" data-field-name="product__id" data-field-required="1" class="form-row field_product_id active">
        <?php snippet('form/survey_radio_boxes', ['options' => $options, 'value' => $value]); ?>
    </div>
</form>