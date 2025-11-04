<?php
$options = $options ?? [];
$other = $other ?? false;
$value = $value ?? '';
?>


<input type="hidden" value="" class="form-input-field form-input">
<?php $i = 0;
foreach ($options as $option) : ?>
    <?php
    $isSelected = $option === $value;
    ?>
    <div class="form-check-field">
        <input class="form-check-input  text-black focus:[box-shadow:none]" type="checkbox" <?= $isSelected ? 'checked ' : '' ?> value="<?= $option ?>" />
        <label class="form-check-label">
            <?= $option ?>
        </label>
    </div>

<?php $i++;
endforeach; ?>
<?php if ($other) : ?>
    <div class="other mt-4">
        <?php
        $otherConfig = [
            'placeholder' => 'Other, ' . (string)$site->form_please_specify(),
            'classNames' => 'checkbox-other no-error',
        ];
        ?>
        <?php snippet('form/input', $otherConfig); ?>
    </div>

<?php endif; ?>