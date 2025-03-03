$(document).ready(function () {
    $("#register-form").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 255,
            },
            email: {
                required: true,
                email: true,
                maxlength: 255,
            },
            phone: {
                required: true,
                digits: true,
            },
            password: {
                required: true,
                minlength: 8,
                strongPassword: true,
            },
            password_confirmation: {
                required: true,
                equalTo: "#password",
            },
            terms: {
                required: true,
            },
        },
        messages: {
            name: {
                required: merchantValidationMessages.register.name.required,
                minlength: merchantValidationMessages.register.name.minlength,
                maxlength: merchantValidationMessages.register.name.maxlength,
            },
            email: {
                required: merchantValidationMessages.register.email.required,
                email: merchantValidationMessages.register.email.email,
                maxlength: merchantValidationMessages.register.email.maxlength,
            },
            phone: {
                required: merchantValidationMessages.register.phone.required,
                // digits: merchantValidationMessages.register.phone.digits,
            },
            password: {
                required: merchantValidationMessages.register.password.required,
                minlength: merchantValidationMessages.register.password.minlength,
            },
            password_confirmation: {
                required: merchantValidationMessages.register.password_confirmation.required,
                equalTo: merchantValidationMessages.register.password_confirmation.equalTo,
            },
            terms: {
                required: merchantValidationMessages.register.terms.required,
            },
        },
        submitHandler: function (form) {
            const phoneInput = document.querySelector("#phone");
            const iti = window.intlTelInputGlobals.getInstance(phoneInput);
            const countryCode = iti.getSelectedCountryData().dialCode;

            // Remove all non-numeric characters from the phone number
            const cleanPhone = phoneInput.value.replace(/\D/g, "");

            console.log("Country Code:", countryCode);
            console.log("Clean Phone:", cleanPhone);

            document.getElementById("country_code").value = countryCode;
            document.getElementById("phone").value = cleanPhone; // Update phone field

            form.submit();
        }
    });

    const phoneInput = document.querySelector("#phone");
    window.intlTelInput(phoneInput, {
        initialCountry: "us",
        separateDialCode: true,
        preferredCountries: ["us", "gb", "in"],
        utilsScript: "assets/js/utils.js",
    });
});
