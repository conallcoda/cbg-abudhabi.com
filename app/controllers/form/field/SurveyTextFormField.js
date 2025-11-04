import AbstractSurveyFormField from './AbstractSurveyFormField';

class SurveyTextFormField extends AbstractSurveyFormField {
    constructor(element, options) {
        super(element, { ...options, type: 'survey_text' });
        this.input = element.querySelectorAll('textarea')[0];
        this.input.addEventListener('keyup', this.handleChanges.bind(this));
    }

    getValue() {
        return this.input ? this.input.value : '';
    }
    setValue(value) {
        this.input.value = value;
    }
}

export default SurveyTextFormField;
