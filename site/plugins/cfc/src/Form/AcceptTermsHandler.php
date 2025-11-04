<?php

namespace CFC\Form;

class AcceptTermsHandler extends AbstractFormHandler
{
    public function getFields()
    {
        return [
            [
                'name' => 'terms__accept',
                'label' => 'Accept Terms',
                'required' => true,
            ],
        ];
    }
}
