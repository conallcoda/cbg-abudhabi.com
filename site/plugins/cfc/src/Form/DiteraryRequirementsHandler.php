<?php

namespace CFC\Form;


class DiteraryRequirementsHandler extends AbstractFormHandler
{

    public function getFields()
    {
        return [
            [
                'name' => 'dietary__requirements',
                'label' => 'Dietary Requirements',
                'required' => true,
            ]
        ];
    }
}
