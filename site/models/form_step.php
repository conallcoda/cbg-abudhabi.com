<?php

use CFC\Form;

class FormStepPage extends Page
{

    protected $handlers = [];
    protected $formHandlers = [
        'form_accept_terms' => Form\AcceptTermsHandler::class,
        'form_fields' => Form\FormFieldsHandler::class,
        'form_dietary_requirements' => Form\DiteraryRequirementsHandler::class,
        'form_jam_session' => Form\JamSessionHandler::class,
        'form_payment' => Form\PaymentHandler::class,
        'form_profile_photo' => Form\ProfilePhotoHandler::class,
        'form_select_product' => Form\SelectProductHandler::class,
        'form_survey' => Form\SurveyHandler::class,
        'form_newsletter' => Form\FormFieldsHandler::class,

    ];
    public function _panel_title()
    {
        $i = 0;
        foreach ($this->parent()->children()->listed() as $step) {
            if ($step->uuid()->id() === $this->uuid()->id()) {
                return sprintf('Step %s: %s', $i, (string)$this->title());
            }
            $i++;
        }
    }


    public function is_first()
    {
        return $this->parent()->children()->template('form_step')->listed()->first()->uuid()->id() === $this->uuid()->id();
    }

    public function is_last()
    {
        return $this->parent()->children()->template('form_step')->listed()->last()->uuid()->id() === $this->uuid()->id();
    }

    public function getHandlers()
    {
        $handlers = [];
        foreach ($this->layout()->toLayouts() as $layout) {
            foreach ($layout->columns() as $column) {
                foreach ($column->blocks() as $block) {
                    $type = $block->type();
                    if (isset($this->formHandlers[$type])) {
                        $fqcn = $this->formHandlers[$type];
                        $handlers[] = new $fqcn($this, $block);
                    }
                }
            }
        }
        return $handlers;
    }

    public function validate(array $data)
    {
        $handlers = $this->getHandlers();
        $isValid = true;
        foreach ($handlers as $handler) {
            $isValid = $handler->validate($data) && $isValid;
        }
        return $isValid;
    }
}
