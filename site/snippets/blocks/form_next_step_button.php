<?php
$text = $block->text()->value();
?>
<div class="mt-16 flex justify-center">
    <?php snippet('button', [
        'text' => $text,
        'element' => 'button',
        'theme' => 'sand',
        'action' => 'form-step#next'
    ]) ?>
</div>