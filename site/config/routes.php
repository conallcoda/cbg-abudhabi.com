<?php

use League\Csv\Writer;
use Kirby\Toolkit\Str;

return [
    'routes' => [
        [
            'pattern' => 'forms/(:any)/(:any)/apply-reduction/(:any)',
            'action' => function ($formId, $submissionId, $code) {

                try {
                    $form = page('page://' . $formId);
                    kirby()->impersonate('kirby');
                    if (!$form) {
                        throw new \Exception(sprintf('Form not found [%s]', $formId));
                    }

                    $submission = $form->find('submissions')->find('page://' . $submissionId);
                    if (!$submission) {
                        throw new \Exception(sprintf('Submission not found [%s]', $submissionId));
                    }

                    $submission = $submission->applyReduction($code);
                    return [
                        'success' => true,
                        'html' => $submission->getCart()->toSummaryHtml()
                    ];
                } catch (\Exception $e) {
                    var_dump($e);
                    die;
                    return [
                        'error' => true,

                        'message' => $e->getMessage()
                    ];
                }
            }
        ],
        [
            'pattern' => 'download-invited-users/(:alphanum).csv',
            'action' => function ($uuid) {
                $user = kirby()->user();
                if (!$user) {
                    return [
                        'error' => true,
                        'message' => 'Access Denied',
                    ];
                }

                $form = page('page://' . $uuid);

                if (!$form) {
                    return [
                        'error' => true,
                        'message' => 'Form not found',
                    ];
                }

                $headers = ['First Name', 'Last Name', 'Email', 'URL'];

                $records = [];

                foreach ($form->invited_users()->toStructure() as $item) {
                    $records[] = [
                        $item->first_name()->value(),
                        $item->last_name()->value(),
                        $item->email()->value(),
                        sprintf('%s?t=%s', $form->url(), $item->access_token()->value()),
                    ];
                }

                $csv = Writer::createFromString();
                $csv->insertOne($headers);
                $csv->insertAll($records);


                $filename =  Str::slug(sprintf('invited-users-%s-%s', (string)$form->id(), date('YmdHis'))) . '.csv';
                header('Content-Type: application/csv');
                header('Content-Disposition: attachment; filename=' . $filename);
                header('Pragma: no-cache');
                return $csv->toString();
            }
        ],
        [
            'pattern' => 'download-submissions/(:alphanum).csv',
            'action' => function ($uuid) {
                $user = kirby()->user();
                if (!$user) {
                    return [
                        'error' => true,
                        'message' => 'Access Denied',
                    ];
                }

                $form = page('page://' . $uuid);

                if (!$form) {
                    return [
                        'error' => true,
                        'message' => 'Form not found',
                    ];
                }

                $fields = $form->getAllFields();
                foreach ($fields as $field) {
                    $headers[] = $field['name'];
                }

                $productId = get('product');
                $submissions = $form->index(true)->template('form_submission');
                $records = [];
                foreach ($submissions as $submission) {
                    $data = $submission->_data();
                    $record = [];
                    if (isset($productId)) {
                        if (!isset($data['product__id']) || $data['product__id'] !== $productId) {
                            continue;
                        }
                    }
                    foreach ($fields as $field) {
                        $record[] = $data[$field['name']] ?? '';
                    }
                    $records[] = $record;
                }


                $csv = Writer::createFromString();
                $csv->insertOne($headers);
                $csv->insertAll($records);

                $filename =  Str::slug(sprintf('submissions-%s-%s.csv', (string)$form->id(), date('YmdHis'))) . '.csv';

                header('Content-Type: application/csv');
                header('Content-Disposition: attachment; filename=' . $filename);
                header('Pragma: no-cache');
                return $csv->toString();
            }
        ],
        [
            'pattern' => 'download-app-links/(:alphanum).csv',
            'action' => function ($uuid) {
                $user = kirby()->user();
                if (!$user) {
                    return [
                        'error' => true,
                        'message' => 'Access Denied',
                    ];
                }

                $page = page('page://' . $uuid);

                if (!$page) {
                    return [
                        'error' => true,
                        'message' => 'Page not found',
                    ];
                }

                $children = $page->children()->template('form')->unlisted();

                $headers = ['Page', 'URL'];
                $records = [];
                foreach ($children as $child) {
                    $records[] = [
                        '[FORM] ' . $child->title()->value(),
                        $child->_preview_url()
                    ];
                }

                $children = $page->children()->template('default')->unlisted();
                foreach ($children as $child) {
                    $records[] = [
                        '[LANDING] ' . $child->title()->value(),
                        $child->_preview_url()
                    ];
                }

                $csv = Writer::createFromString();
                $csv->insertOne($headers);
                $csv->insertAll($records);

                $filename =  Str::slug(sprintf('app-links-%s-%s.csv', (string)$page->id(), date('YmdHis'))) . '.csv';

                header('Content-Type: application/csv');
                header('Content-Disposition: attachment; filename=' . $filename);
                header('Pragma: no-cache');
                return $csv->toString();
            }
        ]

    ]
];
