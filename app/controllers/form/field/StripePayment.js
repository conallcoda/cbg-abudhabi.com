import { loadStripe } from '@stripe/stripe-js';

class StripePayment {
    stripe = null;
    intentSecret = null;
    intentId = null;
    isValid = false;
    error = null;
    card = null;
    changeListeners = [];

    constructor({ stripeKey, intentSecret, intentId, element }) {
        this.stripeKey = stripeKey;
        this.intentSecret = intentSecret;
        this.intentId = intentId;
        this.element = element;
        this.setup();
    }

    async setup() {
        const body = document.getElementsByTagName('body')[0];
        const computed = window.getComputedStyle(body);
        const fontSize = computed.getPropertyValue('font-size');
        this.stripe = await loadStripe(this.stripeKey);
        const elements = this.stripe.elements({
            fonts: [
                { cssSrc: 'https://cfc-stmoritz.com/assets/stripe/font.css' },
            ],
            locale: 'en',
        });
        const style = {
            base: {
                iconColor: '#000000',
                color: '#000000',
                fontFamily: "'Brown', sans-serif",
                fontSmoothing: 'antialiased',
                paddingTop: '9px',
                paddingBottom: '14px',
                fontSize: '18px',
                '::selection': {
                    backgroundColor: 'rgb(239, 239, 239)',
                },
                '::placeholder': {
                    color: '#6b7280',
                },
                ':-webkit-autofill': {
                    color: '#000000',
                },
            },
            invalid: {
                color: '#000000',
                iconColor: '#000000',
            },
        };
        const card = elements.create('card', { style: style });
        card.addEventListener('change', this.handleChange.bind(this));
        card.mount('#card-element');
        this.card = card;
    }

    onChange(callback) {
        this.changeListeners.push(callback);
    }

    handleChanges() {
        this.changeListeners.forEach((fn) => fn(this));
    }

    validate() {
        this.element.classList.remove('has-error');
        if (!this.isValid) {
            this.element.classList.add('has-error');
            return false;
        }
        return true;
    }

    handleChange(e) {
        if (e.error) {
            this.error = e.error.message;
            this.isValid = false;
        } else {
            this.isValid = true;
            this.error = null;
        }

        this.validate();
        this.handleChanges();
    }

    submit({ firstName, lastName, email }, onDone) {
        const data = {
            receipt_email: email,
            payment_method_data: {
                billing_details: { name: `${firstName} ${lastName}` },
            },
        };
        this.stripe
            .handleCardPayment(this.intentSecret, this.card, data)
            .then(onDone);
    }
}

export default StripePayment;
