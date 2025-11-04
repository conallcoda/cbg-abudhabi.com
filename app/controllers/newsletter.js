import { Controller } from '@hotwired/stimulus';
import { debounce } from './util';
import axios from 'axios';

import FormFields from './form/FormFields';

export default class extends Controller {
    static targets = ['error', 'form'];
    messages = {};
    action = null;
    steps = [];
    connect() {
        this.form = new FormFields(this.formTarget);
        this.messages = JSON.parse(atob(this.element.dataset.messages));
        this.action = this.element.dataset.action;

        const items = this.element.getElementsByClassName('newsletter-step');

        for (let i = 0; i < items.length; i++) {
            this.steps.push(items[i]);
        }
    }

    async next(e) {
        e.preventDefault();
        const isValid = this.form.validate();
        if (!isValid) {
            this.showError(this.messages.required);
            return;
        }

        const onSuccess = (r) => {
            this.resetError();
            this.steps[0].classList.remove('active');
            this.steps[1].classList.add('active');
        };

        const onError = (r) => {
            if (r.response && r.response.data && r.response.data.error) {
                this.showError(r.response.data.error);
            } else {
                this.showError(this.messages.unknown);
            }
        };

        const body = this.form.getData();
        axios.post(this.action, body).then(onSuccess).catch(onError);
    }

    showError(message) {
        this.errorTarget.innerHTML = message;
    }
    resetError() {
        this.errorTarget.innerHTML = '';
    }
}
