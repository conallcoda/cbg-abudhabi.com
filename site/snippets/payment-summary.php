<?php

$summary = $summary ?? [];
$hasReduction = $hasReduction ?? false;
?>
<div class="text-sm md:text-base payment-summary-table <?= $hasReduction ? 'has-reduction' : '' ?>">

    <?php foreach ($summary as $item): ?>
        <div class=" flex py-4 last:border-0 border-b border-darkGrey <?= $item['className'] ?? '' ?>">
            <div class="grow pr-2"><?= $item['text'] ?></div>
            <div class="amount"><?= site()->_formatPrice($item['amount']) ?></div>
        </div>
    <?php endforeach; ?>
</div>