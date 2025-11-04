import { Controller } from "@hotwired/stimulus";
import "lightgallery.js";

export default class extends Controller {
  connect() {
    lightGallery(this.element, {
      thumbnail: false,
      download: true,
      controls: true,
    });
  }

  disconnect() {
    window.lgData[this.element.getAttribute("lg-uid")].destroy(true);
  }
}
