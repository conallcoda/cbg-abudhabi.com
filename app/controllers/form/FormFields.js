import Checkbox from './field/CheckboxFormField';
import CheckboxOther from './field/CheckboxOtherFormField';
import Date from './field/DateFormField';
import Radios from './field/RadiosFormField';
import Input from './field/InputFormField';
import Select from './field/SelectFormField';
import ProfilePhoto from './field/ProfilePhotoFormField';
import SurveyCheckboxes from './field/SurveyCheckboxesFormField';
import SurveyRadioBoxes from './field/SurveyRadioBoxesFormField';
import SurveySelect from './field/SurveySelectFormField';
import SurveyText from './field/SurveyTextFormField';

class FormFields {
    firstValidated = false;
    onValidate = null;
    name = null;
    fields = [];
    map = {
        radios: Radios,
        checkbox: Checkbox,
        checkbox_other: CheckboxOther,
        input: Input,
        date: Date,
        select: Select,
        profile_photo: ProfilePhoto,
        survey_checkboxes: SurveyCheckboxes,
        survey_radio_boxes: SurveyRadioBoxes,
        survey_select: SurveySelect,
        survey_text: SurveyText,
    };
    constructor(parent, onValidate = null, selector = 'data-field-name') {

        this.onValidate = onValidate;
        const fields = parent.querySelectorAll(`[${selector}]`);
        this.name = parent.getAttribute('name');
        for (let i = 0; i < fields.length; i++) {
            const el = fields[i];
            const name = el.dataset.fieldName || el.dataset.surveyFieldName;
            const type = el.dataset.fieldType;
            const isRequired = el.dataset.fieldRequired === '1';
            const FieldClass =
                typeof this.map[type] !== 'undefined' ? this.map[type] : null;
            if (FieldClass) {
                this.fields.push(new FieldClass(el, { name, isRequired }));
            }
        }

    }
    validate() {
        let isValid = true;
        this.fields.forEach((field) => {
            field.validate();
            isValid = isValid && field.isValid();
        });

        if (!this.firstValidated && !isValid) {
            this.firstValidated = true;
            this.validateOnChange();
        }

        if (this.onValidate) {
            this.onValidate(isValid);
        }

        return isValid;
    }

    validateOnChange() {
        this.fields.forEach((field) =>
            field.onChange(this.validate.bind(this))
        );
    }

    setValue(name, value) {
        this.fields.forEach((field) => {
            if (field.getName() === name) {
                field.setValue(value);
            }
        });
    }

    getFields() {
        return this.fields;
    }

    getRequiredFields() {
        const items = [];
        this.fields.forEach((field) => {
            if (field.isRequired) {
                items.push(field);
            }
        });
        return items;
    }

    getDataObject() {
        const data = {};
        this.fields.forEach((field) => {
            if (field.getValue()) {
                data[field.getName()] = field.getValue();
            }
        });
        return data;
    }

    getData() {
        const data = new FormData();
        const object = this.getDataObject();
        Object.keys(object).forEach((key) => {
            data.append(key, object[key]);
        });
        return data;
    }
}

export default FormFields;
