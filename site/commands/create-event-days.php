<?php

use Kirby\Uuid\Uuid;
use Kirby\Data\Yaml;
use Kirby\Toolkit\Str;

return [
    'description' => 'Scaffold templates',
    'args' => [],
    'command' => static function ($cli): void {
        kirby()->impersonate('kirby');
        $delete = kirby()->site()->index(true)->template('event_day_item');
        foreach ($delete as $item) {
            $item->delete();
        }
        $delete = kirby()->site()->index(true)->template('event_day');
        foreach ($delete as $item) {
            $item->delete();
        }
        $pages = kirby()->site()->index(true)->template('event');

        // $event2025 = page('page://8rWRsWcSgNQldy1V');
        // $pages = [$event2025];
        foreach ($pages as $page) {
            $days = $page->getDays();
            $start = $page->start_date()->toCarbon();
            $cli->out(sprintf('%s %s [%s]', $page->id(), count($page->getDays()), $start->format('Y-m-d')));
            $date = $start->subDay();
            foreach ($days as $day) {
                $dayData = [];
                $date = $date->addDay();
                $cli->out('     ' . $date->format('Y-m-d'));
                $dayData['title'] = 'Day ' . $day;
                $dayData['date'] = $date->format('l, d.m.Y');
                $dayData['subtitle'] = $page->getSubtitle($day);
                $dayData['sessions'] = [];
                $sessions = $page->getSessions($day);
                foreach ($sessions as $session) {
                    $dayData['sessions'][] = trim($session['title']);
                }

                $createdDay = $page->createChild(
                    [
                        'slug' => 'day-' . $day,
                        'template' => 'event_day',
                        'draft' => false,
                        'content' => $dayData
                    ]
                );
                $cli->out($createdDay->id());



                $method = sprintf('day%s', $day);
                $i = 0;
                foreach ($page->$method()->toStructure() as $event) {
                    $eventData = [
                        'title' => $event->title()->value(),
                        'time_start' => $event->time_start()->value(),
                        'time_finish' => $event->time_finish()->value(),
                        'description' => $event->description()->value(),
                        'speakers' => $event->speakers()->value(),
                        'hide_description' => $event->hide_description()->value(),
                        'hide_speakers' => $event->hide_speakers()->value(),
                    ];

                    $sessionKey = $event->session()->isEmpty() ? 1 : (int)(string)$event->session()->value() - 1;

                    if (isset($dayData['sessions']) && isset($dayData['sessions'][$sessionKey])) {
                        $eventData['session'] = $dayData['sessions'][$sessionKey];
                    } else {
                    }
                    $eventDayItem =  $createdDay->createChild(
                        [
                            'slug' => Str::slug($eventData['title']) . '-' . Uuid::generate(),
                            'template' => 'event_day_item',
                            'draft' => false,
                            'content' => $eventData
                        ]
                    );
                    $cli->out('         ' . $eventDayItem->id());
                    $i++;
                }
            }
        }
    }
];
