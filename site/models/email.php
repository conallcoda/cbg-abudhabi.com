<?php

use Mailgun\Mailgun;

class EmailPage extends Page
{

    public function _panel_title()
    {
        return sprintf('%s [%s]', $this->title()->value(), $this->_type());
    }
    public function _type()
    {
        return $this->type()->value();
    }
    public function _to($submission = null)
    {
        if ($this->type()->value() === 'User') {
            if ($submission) {
                $data = $submission->_data();
                if (!isset($data['contact__email'])) {
                    throw new Exception('No contact email found');
                }
                return $data['contact__email'];
            } else {
                return '[contact__email]';
            }
        } else {
            return $this->to()->value();
        }
    }

    public function _bcc()
    {
        $items = [];
        foreach ($this->bcc()->toStructure() as $item) {
            $items[] = $item->email()->value();
        }

        return implode(',', $items);
    }

    protected function getVariablesFor($submission)
    {

        $subject = $this->subject()->value();
        $body = $this->body()->value();

        $search = $subject . ' ' . $body;
        preg_match_all('/\[(.*?)\]/', $search, $matches);
        $fields = array_unique($matches[1]);

        $data = [];
        $form = $submission->parent()->parent();
        $submissionData = $submission->_data();


        $default = [
            'form__name' => (string)$form->title(),
            'form__url' =>  $form->url(),
            'panel__url' => kirby()->url('panel') . '/pages/' . str_replace('/', '+', $submission->id()),
        ];

        if (isset($submissionData['product__id'])) {
            $product = page('page://' . $submissionData['product__id']);

            $default = array_merge($default, [
                'product__id' => (string)$product->uuid()->id(),
                'product__name' => (string)$product->display_name(),
                'product__code' => (string)$product->_product_code()
            ]);
        }


        foreach ($fields as $field) {
            $data[$field] = $default[$field] ?? null;
            $data[$field] = $submissionData[$field] ?? $data[$field];
        }

        return array_merge($default, $data);
    }

    protected function replaceVariables($text, $variables)
    {

        foreach ($variables as $key => $value) {
            if (!isset($variables)) {
                continue;
            }
            if (!isset($value)) {
                continue;
            }
            $text = str_replace('[' . $key . ']', $value, $text);
        }
        $text = $this->replaceProductVariables($text, $variables);
        return trim($text);
    }

    protected function replaceProductVariables($text, $variables)
    {
        if (!isset($variables['product__code'])) {
            return $text;
        }
        $actualProductCode = $variables['product__code'];
        $pattern = '/\[product:(.*?):(.*?)\]/';
        $matches = [];
        preg_match_all($pattern, $text, $matches);

        foreach ($matches[1] as $index => $productCode) {
            $placeholder = $matches[0][$index];
            $replacementText = $productCode === $actualProductCode ? $matches[2][$index] : '';
            $text = str_replace($placeholder, $replacementText, $text);
        }

        $text = str_replace("  ", " ", $text);
        return $text;
    }

    public function send(\FormSubmissionPage $submission)
    {

        $variables = $this->getVariablesFor($submission);
        $subject = $this->replaceVariables($this->subject()->value(), $variables);
        $body = $this->replaceVariables($this->body()->value(), $variables);
        $bcc = $this->_bcc();
        $data = [
            'from' => sprintf('%s <%s>', option('cfc.email.from.name'), option('cfc.email.from.email_mailer')),
            //'to' => 'conall@coda.works',
            'to' => $this->_to($submission),
            'subject' => $subject,
            'text' => str_replace('<br>', PHP_EOL, $body),
            'html' => $body,
        ];



        if (!empty($bcc)) {
            $data['bcc'] = $bcc;
        }

        try {
            $mg = Mailgun::create(option('mailgun_key'), 'https://api.eu.mailgun.net');
            $mg->messages()->send(option('mailgun_domain_mailer'), $data);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
