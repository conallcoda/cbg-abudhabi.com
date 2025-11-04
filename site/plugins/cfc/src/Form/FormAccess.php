<?php


namespace CFC\Form;

use FormPage;
use FormSubmissionPage;
use Kirby\Http\Request;

class FormAccess
{
    const ERROR_INVALID_ACCESS_TOKEN  = 'invalid_access_token';
    const ERROR_SKIPPED_STEP  = 'skipped_step';
    const ERROR_MAX_SUBMISSIONS  = 'max_submissions';

    const MESSAGES = [
        self::ERROR_INVALID_ACCESS_TOKEN => 'You do not have access to view this page. [EIAT]',
        self::ERROR_SKIPPED_STEP => 'You do not have access to view this page. [ESS]',
        self::ERROR_MAX_SUBMISSIONS => 'We have reached the maximum number of submissions. [EMS]',
    ];

    protected string|null $accessToken = null;
    protected string|null $requestedStep = null;

    protected FormSubmissionPage|null $submission = null;
    public function __construct(protected FormPage $form, protected Request $request)
    {

        $this->form = $form;
        $this->accessToken = $this->request->get('t', null);
        $this->submission = $form->getSubmission();
        $this->requestedStep = $this->request->get('step', null);
    }

    public function getAccess()
    {
        try {
            $this->guardAgainstNoAccessToken();
            $this->guardAgainstSkippedStep();
            $this->guardAgainstMaxSubmissions();
            return true;
        } catch (\Exception $e) {
            if ($this->form->slug() === 'pre-sale') {
                return [
                    'error' => [
                        'code' => '',
                        'title' => 'Private Pre-Reservation is closed',
                        'message' => '
                        The private pre-reservation period has now ended. Our regular application process will open on Wednesday, October 15. <br/> <br/>
                        If you wish to apply for the conference, please do so through our standard application form.',
                    ],
                ];
            }
            $message = self::MESSAGES[$e->getMessage()] ?? $e->getMessage();
            return [
                'error' => [
                    'code' => $e->getMessage(),
                    'title' => 'Error',
                    'message' => $message,
                ],
            ];
        }
    }

    protected function guardAgainstNoAccessToken()
    {
        if ($this->form->restrict_access()->isFalse()) {
            return true;
        }

        $accessTokens = [$this->form->access_token()->value()];
        foreach ($this->form->invited_users()->toStructure() as $item) {
            $accessTokens[] = $item->access_token()->value();
        }

        $currentAccessToken = $this->request->get('t');

        if (in_array($currentAccessToken, $accessTokens)) {
            return true;
        } else {
            throw new \Exception(self::ERROR_INVALID_ACCESS_TOKEN);
        }
    }

    protected function guardAgainstSkippedStep()
    {
        if (is_null($this->submission) || is_null($this->requestedStep)) {
            return true;
        }

        $completedSteps = (int)$this->submission->step_number()->value();



        if ((int)$this->requestedStep > $completedSteps + 1) {
            throw new \Exception(self::ERROR_SKIPPED_STEP);
        }



        return true;
    }

    protected function guardAgainstMaxSubmissions()
    {
        if (!$this->form->restrict_submissions()->isTrue()) {
            return true;
        }
        $completed = $this->form->_completed_submission_count();
        $max = $this->form->_max_submissions_count();
        if ($completed >= $max) {
            throw new \Exception(self::ERROR_MAX_SUBMISSIONS);
        }
    }
}
