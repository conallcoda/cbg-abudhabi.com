<?php
$options = $options ?? [];
$value = $value ?? '';
?>

<div class="question-radio-boxes button-toggles gap-1">
    <?php $i = 0;
    foreach ($options as $option => $label) : ?>
        <?php
        $isSelected = $option === $value;
        ?>
        <a class="button question-option flex-[1] <?= $isSelected ? 'active' : '' ?>" data-value="<?= $option ?>">
            <?= $label ?>
        </a>
    <?php $i++;
    endforeach; ?>
</div>