import Input from './field/InputFormField';
import FormFields from './FormFields';

class SurveyFormFields extends FormFields {
    answerMap = {};
    hasMainQuestion = null;
    constructor(parent, onValidate) {
        super(parent, onValidate, 'data-survey-field-name');
        this.answerMap = JSON.parse(atob(parent.dataset.answerMap));
        this.hasMainQuestion = parent.dataset.hasMainQuestion === '1';
        this.showSurveyQuestions();
        this.fields.forEach((field) =>
            field.onChange(this.showSurveyQuestions.bind(this))
        );
    }

    showSurveyQuestions() {
        let i = 0;

        const activate = (field) => {
            field.activate();
            field.setNumber(i + 1);
            i++;
        };
        const fieldName = (field) => {
            return field.getName().replace(this.name + '__', '');
        };

        let mainAnswer = null;
        const isMainQuestion = (field) => {
            return field.element.dataset.isMainQuestion === '1';
        };

        const isMainCategory = (field) => {
            if (!mainAnswer || !this.answerMap[mainAnswer]) {
                return false;
            }
            return this.answerMap[mainAnswer].includes(fieldName(field));
        };


        const handleDefault = (field) => {
            if (isMainQuestion(field)) {
                mainAnswer = field.getValue();
                activate(field);
            }

            if (isMainCategory(field)) {
                activate(field);
            }
        };

        const handleNetworkingDetails = (field) => {
            if (this.questionHasAnswer('why_attend', 'network')) {
                activate(field);
            }
            if (this.questionHasAnswer('private_why_attend', 'network')) {
                activate(field);
            }
        };

        const handleInvestmentOpportunities = (field) => {
            if (this.questionHasAnswer('private_why_attend', 'investment')) {
                activate(field);
            }
        };

        if (this.hasMainQuestion) {
            this.fields.forEach((field) => {
                field.deactivate();
                const name = fieldName(field);
                switch (name) {
                    case 'why_attend_networking_details':
                        handleNetworkingDetails(field);
                        break;
                    case 'why_attend_investment_opportunities':
                        handleInvestmentOpportunities(field);
                        break;
                    default:
                        handleDefault(field);
                        break;
                }
            });
        } else {
            this.fields.forEach((field) => {
                field.deactivate();
                activate(field);
            });
        }
    }

    getRequiredFields() {
        const items = [];
        this.fields.forEach((field) => {
            if (field.isRequired && field.isActive()) {
                items.push(field);
            }
        });
        return items;
    }

    questionHasAnswer(fieldName, answer) {
        const data = this.getDataObject();
        let normalizedAnswer = answer.toLowerCase().trim();
        let actualAnswer = data['survey__' + fieldName] ?? '';
        actualAnswer = actualAnswer.toLowerCase().trim();
        return actualAnswer.includes(normalizedAnswer);
    }

    getDataObject() {
        const data = {};
        this.fields.forEach((field) => {
            if (field.isActive()) {
                data[field.getName()] = field.getValue();
            }
        });
        return data;
    }
}

export default SurveyFormFields;
