<?php

namespace CFC\Form;


class JamSessionHandler extends AbstractFormHandler
{

    public function getFields()
    {
        return [
            [
                'name' => 'jam_session__participate',
                'label' => 'Jam Session Participation',
                'required' => false,
            ]
        ];
    }
}
