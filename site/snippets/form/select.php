<?php
$options = $options ?? [];
$other = $other ?? false;
$value = $value ?? '';
?>

<select class="form-input-field w-full focus:[box-shadow:none] border-transparent focus:border-black bg-grey  w-full py-4">
    <option value=""> <?= $label ?></option>
    <?php $i = 0;
    foreach ($options as $option) : ?>
        <?php
        $isSelected = $option === $value;
        ?>

        <option <?= $isSelected ? 'selected ' : '' ?> value="<?= $option ?>"><?= $option ?></option>
    <?php $i++;
    endforeach; ?>
    <?php if ($other) : ?>
        <option value="Other">
            Other
        </option>
    <?php endif; ?>
</select>
<?php if ($other) : ?>
    <div class="other mt-4">
        <?php
        $otherConfig = [
            'placeholder' => 'Other, ' . (string)$site->form_please_specify(),
            'classNames' => 'survey-other',
        ];
        ?>
        <?php snippet('form/input', $otherConfig); ?>

    </div>
<?php endif; ?>