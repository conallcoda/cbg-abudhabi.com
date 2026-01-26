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



        <?php
        $formattedOptions = [];
        $formatPackageLine = function (string $text): string {
            $break =  '<br>';

            return preg_replace(
                [
                    '/\s+including\s+/i',
                    '/\s*-\s*((?:CHF|EUR|USD|\$|€)[\s\d,\.]+)/i',
                ],
                [
                    $break . 'including ',
                    $break . '<u>$1</u>',
                ],
                $text
            );
        };
        foreach ($options as $key => $option) {
            $formattedOptions[$key] = $formatPackageLine($option);
        }
        $options = $formattedOptions;
        ?>
        <div class="button-toggles gap-1">
            <?php $i = 0;
            foreach ($options as $option => $label) : ?>
                <?php
                $isSelected = $option === $value;
                ?>
                <a class="button question-option <?= $isSelected ? 'active' : '' ?>" data-value="<?= $option ?>">
                    <?= $label ?>
                </a>
            <?php $i++;
            endforeach; ?>
        </div>
    </div>
</form>