<?php

$existingValue = $page->getExistingValueFor('dietary__requirements');
$options = [
    ['id' => 'payment_diet_1', 'label' => (string)$site->payment_diet_option1()],
    ['id' => 'payment_diet_2', 'label' => (string)$site->payment_diet_option2()],
    ['id' => 'payment_diet_3', 'label' => (string)$site->payment_diet_option3()],

];
$oneChecked = false;
$isChecked = function ($option) use ($existingValue, &$oneChecked) {
    if ($existingValue === $option) {
        $oneChecked = true;
        return true;
    }
};
?>
<form name="dietary" data-handler="form-fields">
    <div class="form-row radios" data-field-type="radios" data-field-name="dietary__requirements" data-field-required="1">
        <?php foreach ($options as $option) : ?>
            <div class="form-radio-option mb-2 flex items-center">
                <input class="form-radio-input text-black focus:[box-shadow:none] " name=" dietary__requirements" <?= $isChecked($option['label']) ? 'checked' : '' ?> value="<?= $option['label'] ?>" id="<?= $option['id'] ?>" type="radio">
                <label class="pt-1 form-check-label pl-2" for="<?= $option['id'] ?>">
                    <?= $option['label'] ?>
                </label>
            </div>
        <?php endforeach; ?>
        <div class="other mt-4">
            <?php
            $otherConfig = [
                'value' => !empty($existingValue) && !$oneChecked ? $existingValue : '',
                'classNames' => 'radio-other',
                'placeholder' => sprintf('Other, %s', (string)$site->form_please_specify())
            ];
            ?>
            <?php snippet('form/input', $otherConfig) ?>
        </div>
    </div>
</form>