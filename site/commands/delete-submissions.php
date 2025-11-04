<?php


return [
    'description' => 'Nice command',
    'args' => [],
    'command' => static function ($cli): void {
        kirby()->impersonate('kirby');
        $submissions = site()->index(true)->filterBy('template', 'form_submission');
        foreach ($submissions as $submission) {
            $cli->out($submission->title());
            $cli->out($submission->id());
            if ($submission->isLocked()) {
                $submission->unlock();
            }
            $submission->delete();
        }
    }
];
