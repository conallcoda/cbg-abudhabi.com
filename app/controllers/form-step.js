import { Controller } from '@hotwired/stimulus';
import { getViewport, debounce, getScrollTop } from './util';
import axios from 'axios';

import FormFields from './form/FormFields';
import SurveyFormFields from './form/SurveyFormFields';
import PaymentFormFields from './form/PaymentFormFields';

export default class extends Controller {
    static targets = ['error'];
    forms = [];
    formNames = [];
    paymentHandler = null;
    submitting = false;
    handlers = {
        'form-fields': FormFields,
        'survey-form-fields': SurveyFormFields,
        'payment-form-fields': PaymentFormFields,
    };

    connect() {
        this.action = this.element.dataset.action;
        this.step = this.element.dataset.step;
        this.t = this.element.dataset.t;
        this.s = this.element.dataset.s;
        const forms = [...this.element.getElementsByTagName('form')];
        this.messages = JSON.parse(atob(this.element.dataset.messages));
        forms.forEach((form) => {
            form.addEventListener('submit', (e) => e.preventDefault());
            const name = form.getAttribute('name');
            const handlerName = form.dataset.handler ?? 'form-fields';
            const Handler = this.handlers[handlerName] ?? FormFields;
            const handlerInstance = new Handler(form);
            if (handlerName === 'payment-form-fields') {
                this.paymentHandler = handlerInstance;
            }
            this.formNames.push(name);
            this.forms.push({
                name: name,
                element: form,
                handler: handlerInstance,
            });
        });
    }

    disconnect() {
        this.forms.forEach((form) => {
            form.removeEventListener('submit', (e) => e.preventDefault());
        });
    }

    async next(e) {
        if (this.submitting) {
            return;
        }
        e.preventDefault();
        this.submitting = true;
        let isValid = true;

        const body = new FormData();
        body.append('step', this.step);
        if (this.s.length) {
            body.append('s', this.s);
        }

        if (this.t.length) {
            body.append('t', this.t);
        }
        if (this.formNames.length) {
            body.append('forms', this.formNames);
        }
        this.forms.forEach((form) => {
            const name = form.name;
            const currentFormValid = form.handler.validate();
            isValid = isValid && currentFormValid;
            if (currentFormValid) {
                const formData = form.handler.getDataObject();
                console.log(formData);
                Object.keys(formData).forEach((key) => {
                    body.append(key, formData[key]);
                });
            }
        });

        if (!isValid) {
            this.submitting = false;
            this.showError(this.messages.required);
            return;
        }
        this.resetError();
        if (this.paymentHandler) {
            this.paymentHandler.submit((e) => {
                if (e.error) {
                    this.submitting = false;
                    this.showError(e.error.message);
                } else {
                    this._doNext(body);
                }
            });
        } else {
            this._doNext(body);
        }
    }

    showError(message) {
        this.errorTarget.innerHTML = message;
    }
    resetError() {
        this.errorTarget.innerHTML = '';
    }
    _doNext(body) {
        const config = {
            headers: { 'content-type': 'multipart/form-data' },
        };

        const onSuccess = (r) => {
            this.submitting = false;
            if (r.data && r.data.redirect) {
                window.location.href = r.data.redirect;
            }
        };

        const onError = (r) => {
            this.submitting = false;
            if (r.response && r.response.data && r.response.data.error) {
                this.showError(r.response.data.error);
            } else {
                this.showError(this.messages.unknown);
            }
        };

        axios.post(this.action, body, config).then(onSuccess).catch(onError);
    }
}
