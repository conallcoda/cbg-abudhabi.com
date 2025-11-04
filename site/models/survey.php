<?php



class SurveyPage extends Page
{
    public function _panel_main_questions()
    {
        return $this->children()->template('form_field')->listed();
    }

    public function _panel_questions()
    {
        return $this->children()->template('form_field')->listed();
    }


    public function _panel_sub_questions()
    {
        $mainQuestion = $this->_main_question();
        if (!$mainQuestion) {
            return [];
        }

        $filter = function ($field) use ($mainQuestion) {
            return $field->id() !== $mainQuestion->id();
        };

        return $this->_panel_main_questions()->filter($filter);
    }

    public function _main_question()
    {
        return $this->main_question()->_page();
    }

    public function _panel_sub_question_answers()
    {
        $mainQuestion = $this->_main_question();
        if (!$mainQuestion) {
            return [];
        }

        $options = [];
        foreach ($mainQuestion->options()->toStructure() as $item) {
            $options[] = (string)$item->title();
        }
        return $options;
    }
}
