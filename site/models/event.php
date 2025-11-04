<?php

use CFC\Model\IsAccessible;
use CFC\Model\HasAccess;
use Kirby\Toolkit\Str;

class EventPage extends Page implements IsAccessible
{
    use HasAccess;

    public function sort_timestamp()
    {
        return strtotime($this->start_date());
    }
    public function getDays()
    {
        return $this->children()->template('event_day')->unlisted()->sortBy('date', 'asc');
    }

    public function  getEventsByDay()
    {
        $data = [];
        foreach ($this->getDays() as $day) {
            $key = (string)$day->title();
            if (!isset($data[$key])) {
                $data[$key] = [];
            }
            $data[$key][] = $day->_data();
        }

        return $data;
    }

    public function getGalleriesByDay()
    {
        $data = [];
        foreach ($this->getDays() as $day) {
            $images = $day->photos()->toFiles();
            if ($images->count() >  0) {
                $data[] = [
                    'title' => (string)$day->title(),
                    'date' => $day->date()->toDate('d.m.Y'),
                    'items' => $images
                ];
            }
        }
        return $data;
    }

    public function getSummariesByDay()
    {
        $data = [];
        foreach ($this->getDays() as $day) {
            if ($day->hasSummaries()) {
                $data[] = [
                    'id' => Str::slug($day->title()),
                    'title' => (string)$day->title(),
                    'date' => $day->date()->toDate('d.m.Y'),
                    'items' => $day->_summaries(),
                ];
            }
        }
        return $data;
    }
}
