import { Controller } from '@hotwired/stimulus';
import * as basicLightbox from 'basiclightbox';

export default class extends Controller {
    static targets = ['image'];
    connect() {
        const img = this.imageTarget;
        const src = this.element.dataset.lightboxUrl;
        this.lightbox = basicLightbox.create(
            `<img src="${src}"  alt="${img.alt}" sizes="100vw">`
        );
    }
    open() {
        this.lightbox.show();
    }
}
