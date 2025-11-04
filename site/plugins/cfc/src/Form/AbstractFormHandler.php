<?php

namespace CFC\Form;


use Kirby\Cms\Block;


abstract class AbstractFormHandler
{

    public function __construct(protected \FormStepPage $step, protected Block $block) {}

    abstract public function getFields();

    public function validate(array $data = [])
    {
        $fields =  $this->getFields();
        foreach ($fields as $field) {
            if ($field['required'] && !isset($data[$field['name']])) {
                throw new \Exception(sprintf('Field %s is required', $field['name']));
            }
        }
        return true;
    }

    public function merge($data, \FormSubmissionPage $submission)
    {
        $new = [];
        foreach ($this->getFields() as $field) {
            $name = $field['name'];
            if (isset($data[$name])) {
                $new[$name] = $data[$name];
            }
        }
        return ['data' => $new];
    }
}
