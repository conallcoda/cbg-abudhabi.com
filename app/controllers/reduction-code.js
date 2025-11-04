import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['summary'];
    input = null;
    error = null;
    connect() {
        const items = this.element.getElementsByClassName('reduction-input');

        for (let i = 0; i < items.length; i++) {
            this.input = items[i];
            break;
        }

        this.input.addEventListener('input', this.resetError.bind(this));
        const errors = this.element.getElementsByClassName('reduction-error');

        for (let i = 0; i < errors.length; i++) {
            this.error = errors[i];
            break;
        }
    }

    disconnect() {
        this.input.removeEventListener('input', this.resetError.bind(this));
    }

    resetError() {
        this.error.innerHTML = '';
    }
    showError(message) {
        this.error.innerHTML = message;
    }
    apply(e) {
        e.preventDefault();
        if (!this.input) {
            return;
        }

        if (!this.input.value.length) {
            return;
        }

        const url =
            this.element.getAttribute('data-end-point') + this.input.value;

        const onSuccess = (data) => {
            if (data.error) {
                this.showError(data.message);
            }

            if (data.html) {
                this.summaryTarget.innerHTML = data.html;
            }
            this.input.value = '';
        };
        const onError = (error) => {
            this.showError('An unknown error ocurred');
        };
        fetch(url)
            .then((r) => r.json())
            .then(onSuccess)
            .catch(onError);
    }
}
