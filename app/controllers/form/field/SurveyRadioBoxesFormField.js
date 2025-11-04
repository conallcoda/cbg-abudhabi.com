import AbstractSurveyFormField from './AbstractSurveyFormField';

class SurveyRadioBoxesFormField extends AbstractSurveyFormField {
    options = [];
    constructor(element, options) {
        super(element, { ...options, type: 'survey_radio_boxes' });
        const items = this.element.getElementsByClassName('question-option');
        for (let i = 0; i < items.length; i++) {
            this.options.push(items[i]);
        }

        this.options.forEach((option) => {
            option.addEventListener('click', () => {
                this.options.forEach((sibling) =>
                    sibling.classList.remove('active')
                );
                option.classList.add('active');
                this.handleChanges(this);
            });
        });
    }

    getValue() {
        let value = '';
        this.options.forEach((option) => {
            if (option.classList.contains('active')) {
                value = option.dataset.value;
            }
        });

        return value;
    }
}

export default SurveyRadioBoxesFormField;
