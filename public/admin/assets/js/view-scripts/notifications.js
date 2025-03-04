const apiUrl = "/admin/notification";
const tableBody = $("tbody");
$(document).ready(function () {
    // Show loading message initially
    tableBody.html(tableLoader());
    fetchDataAndPopulate();
    initializeNotificationForm();
});

/**
 * Populate the table with the given data.
 * @param {array} datas - Array of notification objects
 */
function populateTable(datas) {
    let html = "";
    if (datas.length) {
        datas.forEach(function (data) {
            html += `
                <tr>
                    <td>
                        <div class="d-flex gap-3">
                            <div class="info">
                                <p data-bs-toggle="tooltip" title="${data.title}" class="text-capitalize">${trimString(data.title, 30)}</p>
                            </div>
                        </div>
                    </td>
                    <td><span data-bs-toggle="tooltip" title="${data.message}" class="text-capitalize">${trimString(data.message, 30)}</span></td>
                    <td>${data.recipients}</td>
                    <td>${data.delivery_status}</td>
                   <td>${data.push_time ? new Date(data.push_time).toISOString().replace('T', ' ').split('.')[0] : "N/A"}</td>
                    <td>${data?.created_at ? new Date(data.created_at).toISOString().split('T')[0] : "N/A"}</td>
                    <td>
                        <div class="table-action">
                            <a data-bs-toggle="tooltip" title="Edit ${trimString(data.title, 15)}" class="notification-form-button" href="/admin/notification/${data.id}/edit"><span class="edit">
                                <span class="iconify" data-icon="lucide:edit" data-inline="false"></span>
                            </span></a>
                            <a data-bs-toggle="tooltip" title="Delete ${trimString(data.title, 15)}" href="javascript:void(0)" onclick="deleteData(${data.id}, '${trimString(data.title, 15)}')"> <span class="delete">
                                <span class="iconify" data-icon="mi:delete" data-inline="false"></span>
                            </span></a>
                        </div>
                    </td>
                </tr>
            `;
        });
    } else {
        html = emptyTable(message = "No Notification Available");
    }
    tableBody.html(html);
    initializeNotificationForm();
}

/**
 * Initialize the notification form to be opened in a modal.
 * This function is responsible for:
 * - Binding click event to the edit notification button.
 * - Making an AJAX request to the server to get the notification form.
 * - Populating the modal with the notification form.
 * - Initializing the validation rules for the notification form.
 * - Initializing the submit event for the notification form.
 * - Initializing the select2 for the notification form.
 */
function initializeNotificationForm() {
    $(".notification-form-button")
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
                    updateNotificationValidation();
                    submitDataForm();
                    $("#globalModal").modal("show");
                    implementSelect2OnModel();
                },
            });
        });
}

/**
 * Updates the validation rules for the notification form.
 * This function is responsible for:
 * - Updating the validation rules for the notification form.
 * - Setting the required, maxlength, minlength and noSpecialChars rules.
 * - Setting the error messages for each rule.
 */
function updateNotificationValidation() {
    $(".dataForm").validate({
        rules: {
            title: {
                required: true,
                maxlength: 255,
            },
            message: {
                required: true,
                maxlength: 1000,
            },
            "recipients[]": {
                required: true,
            },
            push_time: {
                required: true,
                date: true,
                min: function() {
                    return new Date().toISOString().slice(0, 16); // Get current date-time in 'YYYY-MM-DDTHH:MM' format
                }
            },
        },
        messages: {
            title: {
                required: notificationsValidation.create_notification.title.required,
                maxlength: notificationsValidation.create_notification.title.maxlength,
            },
            message: {
                required: notificationsValidation.create_notification.message.required,
                maxlength: notificationsValidation.create_notification.message.maxlength,
            },
            "recipients[]": {
                required: notificationsValidation.create_notification.recipients.required,
            },
            push_time: {
                required: notificationsValidation.create_notification.push_time.required,
                date: notificationsValidation.create_notification.push_time.date,
                min: notificationsValidation.create_notification.push_time.min,
            },
        },
    });
}
