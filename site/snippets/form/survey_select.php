<?php
$options = $options ?? [];
$other = $other ?? false;
$value = $value ?? '';
?>

<select class="form-input-field w-full">
    <option value=""> <?= $site->form_please_select() ?></option>
    <?php $i = 0;
    foreach ($options as $option) : ?>
        <?php
        $isSelected = $option === $value;
        ?>
        <div class="question-option">
            <option <?= $isSelected ? 'selected ' : '' ?> value="<?= $option ?>"><?= $option ?></option>
        </div>
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