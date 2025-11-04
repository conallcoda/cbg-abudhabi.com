<?php

use CFC\Form\FormAccess;
use CFC\Model\HasAfterCreateHook;
use CFC\Model\HasAfterDuplicateHook;
use CFC\Model\HasAfterUpdateHook;
use CFC\Model\IsAccessible;
use Kirby\Uuid\Uuid;
use Kirby\Data\Yaml;
use CFC\Model\HasAccess;

class FormPage extends Page implements IsAccessible, HasAfterCreateHook, HasAfterUpdateHook, HasAfterDuplicateHook
{
    use HasAccess;

    protected $formHandlers = [
        'form_fields' => 'handleStep',
    ];


    public function _afterCreate()
    {

        $this->update(['access_token' => Uuid::generate()]);

        $this->createChild([
            'slug' => 'submissions',
            'template' => 'form_submissions',
            'draft' => false,
            'content' => [
                'title' => 'Submissions',
            ]
        ]);
    }


    public function getSubmissionsPage()
    {
        $submissions = $this->find('submissions');
        if (!$submissions) {
            $submissions =  $this->createChild([
                'slug' => 'submissions',
                'template' => 'form_submissions',
                'draft' => false,
                'content' => [
                    'title' => 'Submissions',
                ]
            ]);
        }
        return $submissions;
    }
    public function _completed_submission_count()
    {
        $completed = 0;
        $submissions = $this->find('submissions')->children()->template('form_submission');
        foreach ($submissions as $submission) {
            $completed = $submission->isCompleted() ? $completed + 1 : $completed;
        }
        return $completed;
    }

    public function _max_submissions_count()
    {
        $max = null;
        if ($this->restrict_submissions()->isTrue() && $this->max_submissions()->isNotEmpty()) {
            $max = $this->max_submissions()->value();
        }
        return $max;
    }

    public function _panel_submissions_text()
    {
        $completed = $this->_completed_submission_count();
        $max = $this->_max_submissions_count();
        if ($max) {
            return sprintf('%s/%s', $completed, $max);
        }
        return $completed;
    }

    public function getAccess()
    {
        $request = kirby()->request();
        return (new FormAccess($this, $request))->getAccess();
    }
    public function _afterDuplicate()
    {

        $this->update(['access_token' => Uuid::generate(), 'email_notifications' => Yaml::encode([])]);
        $this->deleteSubmissions();
    }

    public function _afterUpdate($new, $old)
    {

        $data = [];
        foreach ($this->invited_users()->toStructure() as $user) {
            $data[] = [
                'email' => $user->email()->value(),
                'first_name' => $user->first_name()->value(),
                'last_name' => $user->last_name()->value(),
                'access_token' => $user->access_token()->isEmpty() ? Uuid::generate() : $user->access_token()->value(),
            ];
        }

        $this->update(['invited_users' => Yaml::encode($data)]);
    }

    public function _id()
    {
        return $this->uuid()->id();
    }

    public function deleteSubmissions()
    {
        $submissions = $this->find('submissions');
        if ($submissions) {
            foreach ($submissions->children() as $submission) {
                $submission->delete();
            }
        }
    }

    public function _label()
    {
        return (string)$this->label()->or($this->title());
    }
    public function _type()
    {
        return match ($this->type()->value()) {
            'email' => 'email',
            'phone' => 'tel',
            default => 'text',
        };
    }

    public function _test_data_mode()
    {
        return $this->test_data_mode()->isTrue();
    }

    public function _test_payment_mode()
    {
        return $this->test_payment_mode()->isTrue();
    }
    public function _name()
    {
        return str_replace('-', '_', $this->slug());
    }

    public function _test_value($field)
    {
        $data = include __DIR__ . '/data/_testFormData.php';
        return $data[$field] ?? '';
    }

    public function isClosed()
    {
        $hasCloseDate = $this->close_on_date()->isTrue() && $this->close_date()->isNotEmpty();
        if ($hasCloseDate) {
            $closeDate = $this->close_date()->toCarbon();
            return $closeDate->isPast();
        }
        return false;
    }

    public function handleStep($data)
    {
        if ($this->isClosed()) {
            return ['redirect' => $this->url()];
        }
        $submissionId = $data['s'] ?? null;
        $accessToken = $data['t'] ?? null;
        if (!isset($data['step'])) {
            throw new Exception('Step not provided');
        }
        $response = [];
        $currentStep = $this->findStep($data['step']);
        if (!$currentStep) {
            throw new Exception('Step not found');
        }

        if (isset($data['forms'])) {
            $isValid = $currentStep->validate($data);
            $submission = $this->storeSubmission($currentStep, $data);
            if (!isset($submissionId)) {
                $submissionId = $submission->uuid()->id();
            }
        }

        $this->handleEmailsFor($submissionId, $currentStep);
        if ($nextStep = $currentStep->next()) {
            $response['redirect'] = $this->getUrlForStep($nextStep, $submissionId, $accessToken);
        }

        return $response;
    }

    public function getBackButtonUrl(FormStepPage $currentStep)
    {
        $submissionId = get('s', null);
        $accessToken = get('t', null);

        if ($currentStep->is_first() || $currentStep->is_last()) {
            return null;
        }

        return $this->getUrlForStep($currentStep->prev(), $submissionId, $accessToken);
    }

    public function getUrlForStep(FormStepPage $step, $submissionId = null, $accessToken = null)
    {
        $url = sprintf('%s?step=%s', $this->url(), $step->num() - 1);

        if (isset($submissionId)) {
            $url .= sprintf('&s=%s', $submissionId);
        }
        if (isset($accessToken)) {
            $url .= sprintf('&t=%s', $accessToken);
        }

        return $url;
    }

    public function handleEmailsFor($submissionId, FormStepPage $currentStep)
    {
        $submission = $this->getSubmission($submissionId);
        if (!$submission) {
            return;
        }
        foreach ($this->email_notifications()->toStructure() as $item) {

            $afterStep = $item->after_step()->_page();
            $emailToSend = $item->send_email()->_page();
            if (!$afterStep || !$emailToSend) {
                continue;
            }
            if ($afterStep->uuid()->id() !== $currentStep->uuid()->id()) {
                continue;
            }
            $emailToSend->send($submission);
        }
    }

    public function getSteps()
    {
        return $this->children()->template('form_step')->listed();
    }

    public function getStepCount()
    {
        return $this->getSteps()->count();
    }

    public function getAllFields()
    {
        $fields = [];
        foreach ($this->getSteps() as $step) {
            foreach ($step->getHandlers() as $handler) {
                $fields = array_merge($fields, $handler->getFields());
            }
        }

        return $fields;
    }

    public function findStep(int $step)
    {
        $step = $step < 0 ? 0 : $step;
        return $this->getSteps()->nth($step);
    }

    public function storeSubmission($currentStep, array $data)
    {
        if (isset($data['s'])) {
            $submission =   $this->find('submissions')->find('page://' . $data['s']);
            if (!$submission) {
                throw new Exception('Submission not found');
            }
        } else {
            $submission = $this->createSubmission($data);
        }

        if (!$submission instanceof FormSubmissionPage) {
            throw new Exception('Submission not found');
        }

        $submission->updateFromStep($currentStep, $data);
        return $submission;
    }

    public function getAccessToken()
    {
        return get('t', null);
    }

    public function _download_invited_users_url()
    {
        return site()->url() . '/download-invited-users/' . (string)$this->uuid()->id() . '.csv';
    }


    public function _download_submissions_url()
    {
        return site()->url() . '/download-submissions/' . (string)$this->uuid()->id() . '.csv';
    }




    public function getSubmission($submissionId = null)
    {
        if ($submissionId = get('s', $submissionId)) {
            $submission = $this->find('submissions')->find('page://' . $submissionId);
            return $submission;
        }
        return null;
    }

    public function getInviteData()
    {
        $accessToken = get('t', null);
        if (!$accessToken) {
            return [];
        }
        $invitedUsers = $this->invited_users()->toStructure();
        $data = [];
        foreach ($invitedUsers as $item) {
            if ($item->access_token()->value() !== $accessToken) {
                continue;
            }
            $data = [
                'contact__first_name' => $item->first_name()->value(),
                'contact__last_name' => $item->last_name()->value(),
                'contact__email' => $item->email()->value(),
            ];
        }
        return $data;
    }

    public function getSubmissionData()
    {

        if ($submissionId = get('s')) {
            $submission = $this->find('submissions')->find('page://' . $submissionId);
            if ($submission) {
                return $submission->_data();
            }
        }
        return [];
    }

    public function getExistingValueFor($name)
    {
        $inviteData = $this->getInviteData();
        $data = $this->getSubmissionData();

        $data = array_merge($inviteData, $data);
        if (isset($data[$name])) {
            return $data[$name];
        } elseif ($this->_test_data_mode()) {
            return $this->_test_value($name);
        }

        return '';
    }
    protected function createSubmission(array $data)
    {
        $submissions = $this->find('submissions');

        if (!$submissions) {
            throw new Exception('Submissions not found');
        }

        if (isset($data['contact__first_name']) && isset($data['contact__last_name'])) {
            $title = sprintf('%s %s', $data['contact__first_name'], $data['contact__last_name']);
        } else {
            $title = 'Anonymous';
        }
        $submission = $submissions->createChild([
            'slug' => Uuid::generate(),
            'template' => 'form_submission',
            'draft' => false,
            'content' => [
                'title' => $title
            ]
        ]);
        return $submission;
    }
}
