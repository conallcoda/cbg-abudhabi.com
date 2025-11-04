import AbstractFormField from './AbstractFormField';

class InputFormField extends AbstractFormField {
    constructor(element, options) {
        super(element, { ...options, type: 'input' });
        this.input = element.querySelectorAll('input')[0];
        this.input.addEventListener('keyup', this.handleChanges.bind(this));
    }

    getValue() {
        return this.input.value;
    }
    setValue(value) {
        this.input.value = value;
    }

    isValid() {
        if (!this.isRequired) {
            return true;
        }
        if (this.input.getAttribute('type') === 'email') {
            return /\S+@\S+\.\S+/.test(this.input.value);
        }

        if (
            this.input.getAttribute('type') === 'date' &&
            this.input.getAttribute('min')
        ) {
            const inputDate = new Date(this.input.value);
            const currentDate = new Date();

            currentDate.setHours(0, 0, 0, 0);

            return inputDate > currentDate;
        }

        return this.input.value.trim() !== '';
    }
}

export default InputFormField;
