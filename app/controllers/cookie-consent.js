import { Controller } from '@hotwired/stimulus';
export default class extends Controller {
    connect() {
        if (document.cookie.indexOf('cookie-note=1') === -1) {
            this.show();
        }
    }

    show() {
        this.element.classList.add('active');
    }

    hide() {
        this.element.classList.remove('active');
    }

    ok() {
        document.cookie = 'cookie-note=1;path=/;max-age=864000';
        this.hide();
    }
}
