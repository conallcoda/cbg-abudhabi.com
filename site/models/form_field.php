<?php

use Kirby\Toolkit\Str;

class FormFieldPage extends Page
{
    public function _id()
    {
        return $this->uuid()->id();
    }

    public function _label()
    {
        return (string)$this->label()->or($this->title());
    }

    public function _sub_type()
    {
        $type =  match ($this->type()->value()) {
            'email' => 'email',
            'phone' => 'tel',
            'date' => 'date',
            'time' => 'time',
            'text' => 'text',
            default => $this->type()->value(),
        };
        if ($type === 'multiple_answers') {
            return $this->multiple_answers_allow()->isTrue() ? 'checkboxes' : 'select';
        }
        return $type;
    }
    public function _type()
    {
        $type =  match ($this->type()->value()) {
            'email' => 'input',
            'phone' => 'input',
            'date' => 'date',
            'time' => 'input',
            'textarea' => 'textarea',
            'radio_boxes' => 'radio_boxes',
            'multiple_answers' => 'multiple_answers',
            default => 'input',
        };

        if ($type === 'multiple_answers') {
            return $this->multiple_answers_allow()->isTrue() ? 'checkboxes' : 'select';
        }
        return $type;
    }



    public function _name()
    {
        return str_replace('-', '_', $this->slug());
    }
}
