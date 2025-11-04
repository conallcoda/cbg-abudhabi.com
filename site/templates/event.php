<?php

$tabs = [
    'Speakers' => 'speakers',
    'Agenda' => 'agenda',
    'Partners' => 'partners'
];

?>
<?php snippet('layout', slots: true) ?>
<?php snippet('on_off') ?>
<div class="contained py-16" data-controller="tabs">
    <div class="button-toggles mb-16">
        <?php $i = 0;
        foreach ($tabs as $label => $id) : ?>
            <a data-tab-toggle-id="source_<?= $id ?>" data-action="tabs#toggle" class="tab-toggle button <?= $i === 0 ? 'active' : '' ?>"><?= $label ?></a>
        <?php $i++;
        endforeach; ?>
    </div>
    <div class="tab-item active" data-tab-item-id="source_speakers">
        <?php snippet('blocks/event_speakers', ['source' => $page]) ?>
    </div>
    <div class="tab-item" data-tab-item-id="source_agenda">
        <h2 class="mb-16">Agenda</h2>
        <?php snippet('blocks/event_agenda', ['source' => $page]) ?>
    </div>
    <div class="tab-item" data-tab-item-id="source_partners">
        <?php snippet('blocks/event_partners', ['source' => $page]) ?>
    </div>
</div>
<?php endsnippet() ?>