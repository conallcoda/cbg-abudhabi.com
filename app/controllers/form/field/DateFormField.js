import AbstractFormField from './AbstractFormField';
import flatpickr from 'flatpickr';

class DateFormField extends AbstractFormField {
    constructor(element, options) {

        super(element, { ...options, type: 'input' });
        this.input = element.querySelectorAll('input')[0];
        this.fp = flatpickr(this.input, {
            dateFormat: 'd.m.Y',
        });

    }

    getValue() {
        return this.input.value;
    }
    setValue(value) {
        // this.input.value = value;
    }

    reset() {
        //this.input.value = '';
    }

    isValid() {
        if (!this.isRequired) {
            return true;
        }
        return this.input.value.trim() !== '';
    }
}

export default DateFormField;
