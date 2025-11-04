<?php

use CFC\Model\IsAccessible;
use CFC\Model\HasAccess;

class EventDayItemPage extends Page implements IsAccessible
{
    use HasAccess;

    public function has_header()
    {
        return false;
    }

    public function _time_sort()
    {
        $date = $this->parent()->date();
        $time = $this->time_start();
        $dateTimeObject = new DateTime($date . ' ' . $time);
        return $dateTimeObject->getTimestamp();
    }
    public function _time_start()
    {
        return $this->time_start()->isNotEmpty() ? $this->time_start()->toDate('H:i') : null;
    }

    public function _time_finish()
    {
        return $this->time_finish()->isNotEmpty() ? $this->time_finish()->toDate('H:i') : null;
    }
    public function _time_range()
    {
        $timeStart = $this->_time_start();
        $timeFinish = $this->_time_finish();
        $timeRange = $timeStart && $timeFinish ? sprintf('%s - %s', $timeStart, $timeFinish) : $timeStart;
        return $timeRange;
    }

    public function _panel_speakers()
    {
        $items = [];
        foreach ($this->speakers()->split() as $uuid) {
            $page = page($uuid);
            if ($page) {
                $items[] =  $page->title();
            }
        }
        return implode(',', $items);
    }

    public function hasSummary()
    {
        return $this->picture()->isNotEmpty() &&  $this->layout()->isNotEmpty();
    }

    public function _data()
    {
        return [
            'title' => (string)$this->title(),
            'session' => (string)$this->session(),
            'time_start' => $this->_time_start(),
            'time_finish' => $this->_time_finish(),
            'time_range' => $this->_time_range(),
            'description' => (string)$this->description(),
            'speakers' => $this->speakers()->isNotEmpty() ? $this->speakers()->_pages() : [],
            'hide_description' => $this->hide_description()->isTrue(),
            'hide_speakers' => $this->hide_speakers()->isTrue(),
            'picture' => $this->picture()->toFile(),
            'summary' => $this->layout()->isNotEmpty() ? $this->layout() : null,
        ];
    }

    public function related_articles()
    {
        $day = $this->parent();
        $data = [];
        foreach ($day->_summaries() as $item) {
            if ($item->uuid()->id() !== $this->uuid()->id()) {
                $data[] = $item;
            }
        }
        return $data;
    }
}
