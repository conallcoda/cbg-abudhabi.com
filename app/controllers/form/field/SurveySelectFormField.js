import AbstractSurveyFormField from "./AbstractSurveyFormField";

class SurveySelectFormField extends AbstractSurveyFormField {
  select = null;
  other = null;
  constructor(element, options) {
    super(element, { ...options, type: "survey_select" });
    this.select = element.querySelectorAll("select")[0];

    const other = this.element.getElementsByClassName("survey-other");
    if (other.length) {
      this.other = other[0];
      this.other.addEventListener("keyup", this.handleChanges.bind(this));
    }

    this.select.addEventListener("change", () => {
      if (this.other && this.select.value === "Other") {
        this.other.classList.add("active");
      } else if (this.other) {
        this.other.classList.remove("active");
      }
      this.handleChanges(this);
    });
  }

  getValue() {
    const selectValue = this.select.value;
    if (this.other && selectValue === "Other") {
      return "Other: " + this.other.value;
    }
    return this.select.value;
  }
}

export default SurveySelectFormField;
