import AbstractFormField from "./AbstractFormField";

class CheckboxFormField extends AbstractFormField {
  constructor(element, options) {
    super(element, { ...options, type: "input" });
    this.input = element.querySelectorAll("input")[0];
    this.input.addEventListener("click", this.handleChanges.bind(this));
  }

  getValue() {
    return this.input.checked ? this.input.value : undefined;
  }

  isValid() {
    if (!this.isRequired) {
      return true;
    }

    return this.input.checked;
  }
}

export default CheckboxFormField;
