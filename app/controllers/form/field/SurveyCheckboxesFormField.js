import AbstractSurveyFormField from "./AbstractSurveyFormField";

class SurveyCheckboxFormField extends AbstractSurveyFormField {
  options = [];
  other = null;

  constructor(element, options) {
    super(element, { ...options, type: "survey_checkbox" });

    const items = this.element.getElementsByClassName("form-check-input");
    for (let i = 0; i < items.length; i++) {
      this.options.push(items[i]);
      items[i].addEventListener("click", this.handleChanges.bind(this));
    }

    const other = this.element.getElementsByClassName("checkbox-other");
    if (other.length) {
      this.other = other[0];
      this.other.addEventListener("keyup", this.handleChanges.bind(this));
    }
  }

  getValue() {
    const values = [];
    this.options.forEach((item) => {
      if (item.checked) {
        values.push(item.value);
      }
    });

    if (this.other && this.other.value.length) {
      values.push(this.other.value);
    }
    return values.join(", ");
  }
}

export default SurveyCheckboxFormField;
