document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        let maskWrapper = document.querySelector('.numeral-mask-wrapper');

        for (let pin of maskWrapper.children) {
            pin.onkeyup = function (e) {
                // Check if the key pressed is a number (0-9)
                if (/^\d$/.test(e.key)) {
                    if (pin.nextElementSibling && this.value.length === parseInt(this.attributes['maxlength'].value)) {
                        pin.nextElementSibling.focus();
                    }
                } else if (e.key === 'Backspace' && pin.previousElementSibling) {
                    pin.previousElementSibling.focus();
                }
            };

            pin.onkeypress = function (e) {
                if (e.key === '-') {
                    e.preventDefault();
                }
            };
        }

        const twoStepsForm = document.querySelector('#twoStepsForm');

        if (twoStepsForm) {
            const fv = FormValidation.formValidation(twoStepsForm, {
                fields: {
                    otp: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter OTP'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleValidClass: '',
                        rowSelector: '.mb-6'
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    autoFocus: new FormValidation.plugins.AutoFocus()
                }
            }).on('core.form.valid', function (event) {
                // Prevent default form submission
                event.preventDefault();

                // Manually trigger AJAX form submission
                $('#twoStepsForm').trigger('submit.ajax');
            });

            const numeralMaskList = twoStepsForm.querySelectorAll('.numeral-mask');
            const keyupHandler = function () {
                let otpFlag = true, otpVal = '';
                numeralMaskList.forEach(numeralMaskEl => {
                    if (numeralMaskEl.value === '') {
                        otpFlag = false;
                        twoStepsForm.querySelector('[name="otp"]').value = '';
                    }
                    otpVal += numeralMaskEl.value;
                });
                if (otpFlag) {
                    twoStepsForm.querySelector('[name="otp"]').value = otpVal;
                }
            };

            numeralMaskList.forEach(numeralMaskEl => {
                numeralMaskEl.addEventListener('keyup', keyupHandler);
            });
        }
    })();
});
