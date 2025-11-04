import AbstractFormField from "./AbstractFormField";

class CheckboxOtherFormField extends AbstractFormField {
  constructor(element, options) {
    super(element, { ...options, type: "input" });

    this.checkbox = this.element.getElementsByClassName("checkbox-other-checkbox")[0];
    this.other = this.element.getElementsByClassName("checkbox-other-text")[0];

    this.checkbox.addEventListener('click', this.handleChanges.bind(this));
    this.checkbox.addEventListener('click', this.enableOtherWhenChecked.bind(this));

    this.other.addEventListener('keyup', this.handleChanges.bind(this));

  }

  enableOtherWhenChecked() {
    console.log('enableOtherWhenChecked');
    if (this.checkbox.checked) {
      console.log(this.other);
      this.other.parentElement.classList.remove("hidden");
      this.other.setAttribute("required", "required");
      this.other.focus();
    } else {
      this.other.parentElement.classList.add("hidden");
      this.other.removeAttribute("required");
      this.other.value = "";
    }
  }

  getValue() {
    return this.checkbox.checked ? this.other.value : '';
  }

  isValid() {

    if (!this.isRequired) {
      return true;
    }

    if (this.checkbox.checked) {
      return this.other.value.length > 0;
    } else {
      return true;
    }
  }
}

export default CheckboxOtherFormField;
