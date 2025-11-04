import AbstractFormField from './AbstractFormField';

class SelectFormField extends AbstractFormField {
    select = null;
    constructor(element, options) {
        super(element, { ...options, type: 'select' });

        this.select = element.querySelectorAll('select')[0];
        this.select.addEventListener('change', this.handleChanges.bind(this));
    }
    getValue() {
        const selectValue = this.select.value;

        return this.select.value;
    }

    isValid() {
        if (!this.isRequired) {
            return true;
        }

        return this.select.value.trim() !== '';
    }
}

export default SelectFormField;
