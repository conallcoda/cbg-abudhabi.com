<?php

class EventDayPage extends Page
{

    public function _date_text()
    {
        return $this->date()->toCarbon()->format('l, d.m.Y');
    }

    public function _data()
    {

        return [
            'title' => (string)$this->title(),
            'date_text' =>  $this->_date_text(),
            'subtitle' => $this->subtitle()->value(),
            'sessions' => $this->getEventsBySession(),
        ];
    }

    public function getEventsBySession()
    {
        $items = $this->_items();
        if ($this->sessions()->isEmpty()) {
            return [
                ['title' => '', 'events' => $items]
            ];
        }

        $hiddenSessions = $this->hidden_sessions()->split();
        foreach ($this->sessions()->split() as $session) {
            $title = in_array($session, $hiddenSessions) ? '' : $session;
            $sessions[$session] = ['title' => $title, 'events' => []];
        }

        foreach ($items as $item) {
            if (isset($sessions[$item['session']])) {
                $sessions[$item['session']]['events'][] = $item;
            }
        }
        return $sessions;
    }

    public function _agenda_items()
    {
        return $this->children()->template('event_day_item')->listed();
    }

    public function hasSummaries()
    {
        foreach ($this->_agenda_items() as $item) {
            if ($item->hasSummary()) {
                return true;
            }
        }
        return false;
    }

    public function _summaries()
    {
        $items = [];
        foreach ($this->_agenda_items() as $item) {
            if ($item->hasSummary()) {
                $items[] = $item;
            }
        }
        return $items;
    }

    public function _items()
    {
        $items = [];
        foreach ($this->children()->template('event_day_item')->listed() as $item) {
            $items[] = $item->_data();
        }
        return $items;
    }
}
