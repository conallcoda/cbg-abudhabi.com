<?php

namespace CFC\Form;

class PaymentHandler extends AbstractFormHandler
{
    public function getFields()
    {

        $fieldConfig = [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'street_address' => 'Street Address',
            'city' => 'City/Town',
            'country' => 'Country',
            'state_region_province' => 'State/Region/Province'
        ];

        $defaults = [
            'first_name' => 'contact__first_name',
            'last_name' => 'contact__last_name',
            'street_address' => 'postal__address_1',
            'city' => 'postal__city_town',
            'country' => 'postal__country',
            'state_region_province' => 'postal__state_region_province'
        ];


        $optional = ['state_region_province'];
        $fields = [];
        $name = 'billing';
        foreach ($fieldConfig as $originalFieldName => $item) {
            $fieldName = sprintf('%s__%s', $name, $originalFieldName);
            $required = !in_array($originalFieldName, $optional);
            $id = $fieldName;
            $value = $this->step->parent()->getExistingValueFor($fieldName);
            if (empty($value) && isset($defaults[$originalFieldName])) {
                $value = $this->step->parent()->getExistingValueFor($defaults[$originalFieldName]);
            }
            $fields[] = [
                'id' => $id,
                'name' => $fieldName,
                'label' => $item,
                'type' => 'text',
                'required' => $required,
                'disabled' => false,
                'value' => $value,
                'template' => 'form/input',
                'placeholder' => $required ? $item . '*' : $item
            ];
        }
        return $fields;
    }
}
