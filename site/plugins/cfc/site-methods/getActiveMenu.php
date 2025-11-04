<?php


return function () {
    $user = kirby()->user();
    $session = kirby()->session();
    $currentSeason = $this->season()->value();
    if ($user) {
        $activeSeason = $session->get('cfc.season') ? $session->get('cfc.season') : $currentSeason;
    } else {
        $activeSeason = $currentSeason;
    }
    return $activeSeason === 'on' ? $this->main_menu_onseason()->toStructure() : $this->main_menu_offseason()->toStructure();
};
