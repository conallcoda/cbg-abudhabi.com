<?php

$existingValue = $page->getExistingValueFor('jam__session');

$oneChecked = false;
$isChecked = function ($option) use ($existingValue, &$oneChecked) {
    if ($existingValue === $option) {
        $oneChecked = true;
        return true;
    }
};
?>
<form name="jam" data-handler="form-fields">

    <div class="form-row checkbox mt-2" data-field-type="checkbox_other" data-field-name="jam_session__participate" data-field-required="1">
        <label class="flex items-center cursor-pointer">
            <input class="checkbox-other-checkbox text-black focus:[box-shadow:none]" type="checkbox" value="" required>
            <p class="pl-4">
                <?= (string)$site->payment_jam_session_checkbox() ?>
            </p>
        </label>
        <div class="other hidden">
            <?php
            $otherConfig = [
                'value' => !empty($existingValue) && !$oneChecked ? $existingValue : '',
                'classNames' => 'checkbox-other-text radio-other',
                'placeholder' => (string)$site->payment_jam_session_placeholder()
            ];
            ?>
            <?php snippet('form/input', $otherConfig) ?>
        </div>
    </div>


</form>