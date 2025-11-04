<?php

namespace CFC\Form;

class FormFieldsHandler extends AbstractFormHandler
{
    public function getFields()
    {
        $name = $this->block->name()->value();
        $fields = [];
        $optional = [];
        foreach ($this->block->optional()->_pages() as $item) {
            $optional[$item->uuid()->id()] = true;
        }

        foreach ($this->block->items()->_pages() as $item) {
            $fieldName = sprintf('%s__%s', $name, $item->_name());
            $id = $item->_id();
            $required = !isset($optional[$id]);
            $options = [];
            foreach ($item->options()->toStructure() as $option) {
                $value = $option->title()->value();
                $options[$value] = $value;
            }
            $fields[] = [
                'id' => $id,
                'name' => $fieldName,
                'label' => $item->_label(),
                'type' => $item->_type(),
                'required' => $required,
                'disabled' => false,
                'value' => $this->step->parent()->getExistingValueFor($fieldName),
                'template' => sprintf('form/%s', $item->_sub_type()),
                'placeholder' => $required ? $item->_label() . '*' : $item->_label(),
                'options' => $options,
            ];
        }
        return $fields;
    }
}
