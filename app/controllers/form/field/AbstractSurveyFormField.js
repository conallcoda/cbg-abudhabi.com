import AbstractFormField from "./AbstractFormField";

class AbstractSurveyFormField extends AbstractFormField {
  number = null;
  constructor(element, options) {
    super(element, options);
    this.number = element.querySelectorAll(".question-number")[0];
  }
  setNumber(number) {
    this.number.innerHTML = number;
  }

  deactivate() {
    this.element.classList.remove("active");
  }
  activate() {
    this.element.classList.remove("active");
    this.element.classList.add("active");
  }

  isActive() {
    return this.element.classList.contains("active");
  }
  isValid() {
    if (!this.isRequired || !this.isActive()) {
      return true;
    }

    return this.getValue().trim() !== "";
  }
}

export default AbstractSurveyFormField;
