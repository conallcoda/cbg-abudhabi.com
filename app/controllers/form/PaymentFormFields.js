import FormFields from './FormFields';
import StripePayment from './field/StripePayment';

class PaymentFormFields extends FormFields {
    constructor(parent, onValidate) {
        super(parent, onValidate);
        const { stripeKey, intentId, intentSecret } = parent.dataset;
        this.stripe = new StripePayment({
            stripeKey,
            intentId,
            intentSecret,
            element: document.getElementById('card-element-container'),
        });
    }
    validate() {
        const isValid = super.validate();
        const isStripeValid = this.stripe.validate();
        return isValid && isStripeValid;
    }

    submit(callback) {
        const data = this.getDataObject();
        const config = {
            firstName: data.billing__first_name,
            lastName: data.billing__last_name,
            email: data.billing__email,
        };
        this.stripe.submit(config, callback);
    }
}

export default PaymentFormFields;
