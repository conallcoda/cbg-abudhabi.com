class AbstractFormField {
    name = null;
    isRequired = null;
    element = null;
    type = null;
    changeListeners = [];

    constructor(element, options) {
        const { name, isRequired, type } = options;
        this.element = element;
        this.name = name;
        this.type = type;
        this.isRequired = isRequired;
    }

    onChange(callback) {
        this.changeListeners.push(callback);
    }

    handleChanges() {
        this.changeListeners.forEach((fn) => fn(this));
    }

    getLabel() {
        return this.label;
    }
    getValue() {}

    setValue() {}

    isValid() {}

    validate() {
        this.element.classList.remove('has-error');
        if (!this.isValid()) {
            this.element.classList.add('has-error');
        }
    }

    getName() {
        return this.name;
    }
}

AbstractFormField.prototype.getLabel = () => this.label;

export default AbstractFormField;
