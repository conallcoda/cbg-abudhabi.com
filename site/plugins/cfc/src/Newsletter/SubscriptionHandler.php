<?php

namespace CFC\Newsletter;

use MailchimpMarketing\ApiClient;
use GuzzleHttp\Exception\RequestException;
use Kirby\Http\Request;

class SubscriptionHandler
{
    const ERROR_UNKOWN = 'An unknown error occurred during subscription.';

    protected ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
        $this->client->setConfig([
            'apiKey' => option('mailchimp_key'),
            'server' => 'us18'
        ]);
    }

    public function handle(Request $request)
    {
        $data = $request->body()->toArray();
        $this->guardAgainstMissingFields($data);
        return $this->subscribe($data);
    }

    protected function subscribe($data)
    {
        try {
            $response = $this->client->lists->addListMember(option('mailchimp_list_id'), [
                'email_address' => $data['contact__email'],
                'status' => 'pending',
                'merge_fields' => [
                    'FNAME' => $data['contact__first_name'],
                    'LNAME' => $data['contact__last_name'],
                ]
            ]);
            return ['success' => true];
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
                if (isset($responseBody['title']) && $responseBody['title'] === 'Member Exists') {
                    //  throw new \Exception('You have already subscribed to our newsletter. Please check your inbox for a confirmation E-Mail.');
                } else {
                    $this->triggerUnknownError('E1');
                }
            } else {
                $this->triggerUnknownError('E2');
            }
        } catch (\Exception $e) {
            $this->triggerUnknownError('E3');
        }
    }

    protected function triggerUnknownError($code)
    {
        throw new \Exception(sprintf('%s [%s]', self::ERROR_UNKOWN, $code));
    }
    protected function guardAgainstMissingFields(array $data)
    {
        $required = ['contact__first_name', 'contact__last_name', 'contact__email'];

        foreach ($required as $field) {
            if (!isset($data[$field])) {
                throw new \Exception("Field $field is required.");
            }
        }
    }
}
