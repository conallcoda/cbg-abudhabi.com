<?php

use CFC\Form\FormAccess;

return function ($page) {

    $request = kirby()->request();
    kirby()->impersonate('kirby');
    if ($request->is('post')) {
        $body = $request->body()->toArray();
        header('Content-type: application/json; charset=utf-8');
        try {
            echo json_encode($page->handleStep($body));
            die;
        } catch (Exception $e) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['error' => $e->getMessage()]);
            die;
        }
    }

    $redirectStep = null;
    $requestedStep = get('step', null);
    $requestedStep = !is_null($requestedStep) ? (int)$requestedStep : null;

    $submission = $page->getSubmission();



    if ($requestedStep > 1 && !$submission) {
        $redirectStep = 0;
    }

    if ($submission) {
        $completedSteps = (int)$submission->step_number()->value();
        if ($requestedStep > $completedSteps + 1) {
            $redirectStep = $completedSteps + 1;
        }


        $isCompleted = $completedSteps === $page->getStepCount() - 2;
        $lastStep = $page->getStepCount() - 1;
        if ($isCompleted && $requestedStep !== $lastStep) {
            $redirectStep = $lastStep;
        }
    }

    if (isset($redirectStep)) {
        $url = $page->url();
        $url .= '?step=' . $redirectStep;
        if ($accessToken = $page->getAccessToken()) {
            $url .= '&t=' . $accessToken;
        }
        if ($s = get('s')) {
            $url .= '&s=' . $s;
        }
        go($url);
        die;
    }


    return [];
};
