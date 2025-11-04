<?php

namespace CFC\Form;

class SurveyHandler extends AbstractFormHandler
{
    public function getFields()
    {

        $source = $this->block->source()->_page_multi();
        $name = $this->block->name()->value();
        if (!$source) {
            return [];
        }

        $items = [];


        $mainQuestion = $source->main_question()->_page();
        if ($mainQuestion) {
            $items[$mainQuestion->_id()] = $mainQuestion;
        }

        $items = $source->children()->template('form_field')->listed();
        $fields = [];
        $optional = [];
        foreach ($source->optional()->_pages_multi() as $item) {
            $optional[$item->_id()] = true;
        }

        foreach ($items as $item) {
            $fieldName = sprintf('%s__%s', $name, $item->_name());
            $id = $item->_id();

            $type = $item->_type();
            $type = $type === 'input' ? 'text' : $type;
            $type = 'survey_' . $type;
            $options = [];
            foreach ($item->options()->toStructure() as $option) {
                $value = $option->title()->value();
                $options[$value] = $value;
            }
            $fields[] = [
                'id' => $id,
                'name' => $fieldName,
                'label' => $item->_label(),
                'type' => $type,
                'required' => !isset($optional[$id]),
                'disabled' => false,
                'value' => $this->step->parent()->getExistingValueFor($fieldName),
                'template' => sprintf('form/%s', $type),
                'placeholder' => $item->placeholder()->value(),
                'options' => $options,
                'other' => $item->multiple_answers_allow_other()->isTrue(),
            ];
        }
        return $fields;
    }

    public function validate(array $data = [])
    {
        return true;
    }

    public function hasMainQuestion()
    {
        $source = $this->block->source()->_page_multi();
        return $source->main_question()->isNotEmpty();
    }

    public function getAnswerMap()
    {

        $source = $this->block->source()->_page_multi();
        $name = $this->block->name()->value();
        if (!$source) {
            return [];
        }

        $items = [];
        $answerMap = [];

        $mainQuestion = $source->main_question()->_page_multi();
        if ($mainQuestion) {
            $items[$mainQuestion->_id()] = $mainQuestion;
            foreach ($mainQuestion->options()->toStructure() as $option) {
                $answerMap[$option->title()->value()] = [];
            }
        }

        foreach ($source->sub_questions()->toStructure() as $item) {
            $answer = $item->if_answer()->value();
            foreach ($item->then_ask()->toPages() as $subItem) {
                $items[$subItem->_id()] = $subItem;
                $answerMap[$answer][] = $subItem->_name();
            }
        }
        return $answerMap;
    }
}
