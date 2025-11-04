import AbstractFormField from './AbstractFormField';
import Croppie from 'croppie';

class ProfilePhotoFormField extends AbstractFormField {
    cropTarget = null;
    error = null;
    blob = null;
    constructor(element, options) {
        super(element, { ...options, type: 'profile_photo' });

        this.input = element.querySelectorAll('input')[0];
        this.cropTarget = element.querySelectorAll('.cropper')[0];
        this.errorTarget = element.querySelectorAll('.photo-error')[0];
        this.existingValue = element.dataset.value;

        if (this.existingValue) {
            this.croppie = new Croppie(this.cropTarget, {
                enableResize: true,
                enableExif: true,
                viewport: {
                    width: 200,
                    height: 270,
                },
                boundary: {
                    width: 300,
                    height: 300,
                },
            });
            this.croppie.bind({
                url: this.existingValue,
            });
            this.cropTarget.classList.add('active');
        } else {
            this.croppie = new Croppie(this.cropTarget, {
                enableResize: true,
                enableExif: true,
                viewport: {
                    width: 200,
                    height: 270,
                },
                boundary: {
                    width: 300,
                    height: 300,
                },
            });
        }

        const that = this;
        this.cropTarget.addEventListener('update', (e) => {
            this.croppie.result('blob').then((blob) => {
                that.blob = blob;
            });
        });

        const readFile = () => {
            const input = this.input;
            this.element.classList.remove('has-error');
            const that = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    that.cropTarget.classList.add('active');
                    that.croppie
                        .bind({
                            url: e.target.result,
                        })
                        .then(function () {});
                };
                reader.readAsDataURL(input.files[0]);
            } else {
            }
        };

        this.input.addEventListener('change', readFile.bind(this));
    }

    getValue() {
        return this.blob;
    }

    isValid() {
        if (!this.isRequired) {
            return true;
        }
        return this.blob !== null;
    }
}

export default ProfilePhotoFormField;
