<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

use CFC\Newsletter\SubscriptionHandler;


return function (\Kirby\Cms\App $kirby, $site, $page) {

    kirby()->impersonate('kirby');
    $request = $kirby->request();
    if ($request->is('post')) {
        try {
            $currentStep = $page->findStep(0);
            $data = $request->body()->toArray();
            $submission = $page->storeSubmission($currentStep, $data);
            if (!isset($submissionId)) {
                $submissionId = $submission->uuid()->id();
            }
            $page->handleEmailsFor($submissionId, $currentStep);
            $handler = new SubscriptionHandler();
            $response = $handler->handle($request);
            echo json_encode($response);
            die;
        } catch (\Exception $e) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['error' => $e->getMessage()]);
            die;
        }
    }
    return [];
};
