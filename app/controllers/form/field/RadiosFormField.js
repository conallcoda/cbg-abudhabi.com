import AbstractFormField from './AbstractFormField';

class RadiosFormField extends AbstractFormField {
    options = [];
    other = null;

    constructor(element, options) {
        super(element, { ...options, type: 'radios' });

        const items = this.element.getElementsByClassName('form-radio-input');
        const other = this.element.getElementsByClassName('radio-other');
        if (other.length) {
            this.other = other[0];
        }
        for (let i = 0; i < items.length; i++) {
            this.options.push(items[i]);
            items[i].addEventListener('click', () => {
                this.handleChanges.bind(this)();
                if (this.other) {
                    this.other.value = '';
                }
            });
        }
        if (this.other) {
            this.other.addEventListener('keyup', () => {
                this.options.forEach((item) => {
                    item.checked = false;
                });
                this.handleChanges.bind(this)();
            });
        }
    }

    getValue() {
        let value = null;
        if (this.other && this.other.value.length) {
            value = this.other.value;
        }

        this.options.forEach((item) => {
            if (item.checked) {
                value = item.value;
            }
        });

        return value;
    }

    isValid() {
        if (!this.isRequired) {
            return true;
        }

        const value = this.getValue();
        return value && value.length;
    }
}

export default RadiosFormField;
