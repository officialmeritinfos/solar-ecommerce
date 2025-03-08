document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        let maskWrapper = document.querySelector('.numeral-mask-wrapper');

        for (let pin of maskWrapper.children) {
            pin.onkeyup = function (e) {
                // Ensure key is a number (0-9)
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
            const numeralMaskList = twoStepsForm.querySelectorAll('.numeral-mask');
            const hiddenOtpInput = twoStepsForm.querySelector('[name="otp"]');

            // Update hidden input when OTP is entered
            const keyupHandler = function () {
                let otpValue = '';

                numeralMaskList.forEach(numeralMaskEl => {
                    otpValue += numeralMaskEl.value;
                });

                hiddenOtpInput.value = otpValue; // Store OTP in hidden field

                console.log("Updated OTP:", hiddenOtpInput.value); // Debugging log
            };

            numeralMaskList.forEach(numeralMaskEl => {
                numeralMaskEl.addEventListener('keyup', keyupHandler);
            });
        }
    })();
});
