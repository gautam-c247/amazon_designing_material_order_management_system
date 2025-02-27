const tableBody = $("tbody");
// change api url accordingaly as per you url
const apiUrl = "/admin/users";
$(document).ready(function () {
    // Show loading message initially
    tableBody.html(tableLoader());
    fetchDataAndPopulate();
});
function populateTable(users) {
    let html = "";
    if (users.length) {
        users.forEach(function (user) {
            const initials = user.name
                .split(" ")
                .slice(0, 2)
                .map((word) => word[0]?.toUpperCase() || "")
                .join("");

            html += `
                <tr>
                    <td>
                        <div class="d-flex gap-3">
                        ${
                            user?.profile_picture
                                ? `<img class="img-profile img-profile-icon me-1 border-radius-1" style="width: 40px;" src="${
                                      "/storage/" + user.profile_picture
                                  }" alt="User Image">`
                                : `<label class="profile-initials">${initials}</label>`
                        }
                            <div class="info">
                                <p data-bs-toggle="tooltip" title="${
                                    user.name
                                }">${trimString(user.name, 20)}</p>
                                <p data-bs-toggle="tooltip" title="${
                                    user.email
                                }">${trimString(user.email, 20)}</p>
                            </div>
                        </div>
                    </td>
                    <td>${user?.contact_no || "N/A"}</td>
                    <td data-bs-toggle="tooltip" title="${
                        user.email
                    }">${trimString(user.email, 20)}</td>
                    <td>${user?.gender ? capitalize(user?.gender) : "N/A"}</td>
                    <td>${trimString(
                        user?.location ? capitalize(user.location) : "N/A",
                        20
                    )}</td>
                    <td>${user?.date_of_birth || "N/A"}</td>
                     <td><a class="change-status" href="users/${
                         user.id
                     }/change-status" data-bs-toggle="tooltip" title="Click to ${
                user.status == 1 ? "Inactive" : "Active"
            }" href="javascript:void(0)">${
                user.status == "1"
                    ? "<span class='badge sucess'>Active</span>"
                    : "<span class='badge warning'>Inactive</span>"
            }</a></td>
<td>${user?.created_at ? new Date(user.created_at).toISOString().split('T')[0] : "N/A"}</td>

                    <td>
                    <div class="table-action">
                    <a data-bs-toggle="tooltip" title="Edit ${trimString(
                        user.name,
                        15
                    )}" class="user-form-button" href="/admin/users/${
                user.id
            }/edit">
                        <span class="edit">
                            <span class="iconify" data-icon="lucide:edit" data-inline="false"></span>
                        </span>
                    </a>
                    <a data-bs-toggle="tooltip" title="Delete ${
                        user.name
                    }" href="javascript:void(0)" onclick="deleteData(${
                user.id
            }, '${user.name}')">
                        <span class="delete">
                            <span class="iconify" data-icon="mi:delete" data-inline="false"></span>
                        </span>
                    </a>
                </div>
                    </td>
                </tr>
            `;
        });
    } else {
        html = emptyTable(message = "No User Available");
    }
    tableBody.html(html);
    initializeUserModel();
    var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    triggerChangeStatus();
}
const today = new Date();
today.setFullYear(today.getFullYear() - 18);

function initializeIntlTelInput() {
    const phoneInput = document.querySelector("#phone");
    const countryCodeInput = document.querySelector("#country_code");

    // Get the stored country code (e.g., +44)
    const storedCountryCode = countryCodeInput.value;

    if (phoneInput) {
        const iti = window.intlTelInput(phoneInput, {
            initialCountry: storedCountryCode ? getCountryIso2(storedCountryCode) : "auto", // Use the stored country code
            separateDialCode: true,
            preferredCountries: ["us", "gb", "in"],
            utilsScript: "{{ asset('admin/assets/js/utils.js') }}"
        });

        // Set the country code when changing country selection
        phoneInput.addEventListener("countrychange", function () {
            const selectedCountryData = iti.getSelectedCountryData();
            countryCodeInput.value = selectedCountryData.dialCode; // Ensure it's updated
        });

        // Update the country code before form submission
        document.querySelector("form").addEventListener("submit", function () {
            const selectedCountryData = iti.getSelectedCountryData();
            countryCodeInput.value = selectedCountryData.dialCode; // Ensure it's updated before submission
        });
    }
}

// Function to get country ISO2 code from dial code (e.g., +44 => gb)
function getCountryIso2(dialCode) {
    const countryData = window.intlTelInputGlobals.getCountryData();
    const country = countryData.find(c => c.dialCode == dialCode);
    return country ? country.iso2 : "us";
}

function initializeUserModel() {
    $(".user-form-button")
        .off("click")
        .click(function (e) {
            e.preventDefault();
            let url = $(this).attr("href");
            $.ajax({
                url: url,
                method: "GET",
                dataType: "html",
                success: function (response) {
                    $("#globalModal .modal-content").html(response);
                    validateCreateUserForm();
                    submitDataForm();

                    const formattedToday = today.toISOString().split("T")[0]; // Format as "yyyy-mm-dd"
                    const formattedDate = $(
                        'input[name="date_of_birth"]'
                    ).val();

                    const dateToUse = formattedDate
                        ? formattedDate
                        : formattedToday;

                    $("#date_of_birth").datepicker({
                        format: "yyyy-mm-dd",
                        maxDate: today,
                        autoclose: true,
                        value: dateToUse, // Set the date (if exists, use it; otherwise, use today's date)
                    });

                    // Initialize intlTelInput after modal content has loaded
                    initializeIntlTelInput();

                    $("#globalModal").modal("show");
                },
            });
        });
}

document.addEventListener("DOMContentLoaded", function () {
    initializeUserModel();
});



function validateCreateUserForm() {
    $(".dataForm").validate({
        rules: {
            email: {
                required: true,
                email: true,
                maxlength: 50,
            },
            name: {
                required: true,
                maxlength: 50,
                noSpecialChars: true,
            },
            contact_no: {
                maxlength: 10,
                minlength: 10,
                digits: true,
            },
            location: {
                required: true,
                maxlength: 50,
            },
            profile_picture: {
                filesize: 2 * 1024 * 1024, // 2MB in bytes
            },
            gender: {
                required: true,
                maxlength: 50,
            },
            date_of_birth: {
                required: true,
                date: true,
            },
        },
        messages: {
            email: {
                required: userValidationMessages.create_user.email.required,
                email: userValidationMessages.create_user.email.email,
                maxlength: userValidationMessages.create_user.email.maxlength,
            },
            name: {
                required: userValidationMessages.create_user.name.required,
                maxlength: userValidationMessages.create_user.name.maxlength,
            },
            contact_no: {
                maxlength:
                    userValidationMessages.create_user.contact_no.maxlength,
                minlength:
                    userValidationMessages.create_user.contact_no.minlength,
                digits: userValidationMessages.create_user.contact_no.digits,
            },
            location: {
                required: userValidationMessages.create_user.location.required,
                maxlength:
                    userValidationMessages.create_user.location.maxlength,
            },
            profile_picture: {
                filesize:
                    userValidationMessages.create_user.profile_picture.filesize,
            },
            gender: {
                required: userValidationMessages.create_user.gender.required,
                maxlength: userValidationMessages.create_user.gender.maxlength,
            },
            date_of_birth: {
                required:
                    userValidationMessages.create_user.date_of_birth.required,
                date: userValidationMessages.create_user.date_of_birth.date,
            },
        },
    });
    $('#contact_no').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
}
