const apiUrl = "/brands";
const tableBody = $("tbody");
$(document).ready(function () {
    // Show loading message initially
    tableBody.html(tableLoader());
    fetchDataAndPopulate();
    initializeCatForm();
});
/**
 * Populate the table with the given data.
 * @param {array} datas - Array of brand objects
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
                                <p data-bs-toggle="tooltip" title="${data.name}" class="text-capitalize">${trimString(data.name, 30)}</p>
                            </div>
                        </div>
                    </td>
                    <td><span data-bs-toggle="tooltip" title="${data.category.name}" class="text-capitalize">${trimString(data.category.name, 30)}</span></td>
                    <td><img src="${data.logo}" alt="${data.name}" width="50"></td>
                    <td><a href="${data.website_url}" target="_blank">URL</a></td>

                    <td><a class="change-status" href="brand/${
                         data.id
                     }/change-status" data-bs-toggle="tooltip" title="Click to ${
                data.status == 1 ? "Inactive" : "Active"
            }" href="javascript:void(0)">${
                data.status == "1"
                    ? "<span class='badge sucess'>Active</span>"
                    : "<span class='badge warning'>Inactive</span>"
            }</a></td>

                    <td>
                        <div class="table-action">
                            <a data-bs-toggle="tooltip" title="Edit ${trimString(data.name, 15)}" class="cat-from-button" href="${apiUrl+'/'+data.id}/edit"><span class="edit">
                                <span class="iconify" data-icon="lucide:edit" data-inline="false"></span>
                            </span></a>
                            <a data-bs-toggle="tooltip" title="Delete ${trimString(data.name, 15)}" href="javascript:void(0)" onclick="deleteData(${data.id}, '${trimString(data.name, 15)}')"> <span class="delete">
                                <span class="iconify" data-icon="mi:delete" data-inline="false"></span>
                            </span></a>

                        </div>
                    </td>
                </tr>
            `;
        });
    } else {
        html = emptyTable(message = "No Brand Available");
    }
    tableBody.html(html);
    initializeCatForm();
    triggerChangeStatus();
}

/**
 * Initialize the category form to be opened in a modal.
 * This function is responsible for:
 * - Binding click event to the edit category button.
 * - Making an AJAX request to the server to get the category form.
 * - Populating the modal with the category form.
 * - Initializing the validation rules for the category form.
 * - Initializing the submit event for the category form.
 * - Initializing the select2 for the category form.
 */
function initializeCatForm() {
    $(".cat-from-button")
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
                    updateCatValidation();
                    $("#globalModal").modal("show");
                    implementSelect2OnModel();
                    submitDataForm();
                },
            });
        });
}

/**
 * Updates the validation rules for the category form.
 * This function is responsible for:
 * - Updating the validation rules for the category form.
 * - Setting the required, maxlength, minlength and noSpecialChars rules.
 * - Setting the error messages for each rule.
 */
function updateCatValidation() {
    const isEdit = $("form").attr("method") === "PUT";

    $(".dataForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 255,
            },
            category_id: {
                required: true,
            },
            logo: {
                required: !isEdit,
                // extension: "jpg|jpeg|png|gif",
            },
            website_url: {
                url: true,
            },
            about: {
                maxlength: 1000,
            },
            pronunciation: {
                maxlength: 255,
            },
            instagram_url: {
                url: true,
            },
        },
        messages: {
            name: {
                required: brandsValidation.create_brand.name.required,
                minlength: brandsValidation.create_brand.name.minlength,
                maxlength: brandsValidation.create_brand.name.maxlength,
            },
            category_id: {
                required: brandsValidation.create_brand.category_id.required,
            },
            logo: {
                required: brandsValidation.create_brand.logo.required,
                extension: brandsValidation.create_brand.logo.extension,
            },
            website_url: {
                url: brandsValidation.create_brand.website_url.url,
            },
            about: {
                maxlength: brandsValidation.create_brand.about.maxlength,
            },
            pronunciation: {
                maxlength: brandsValidation.create_brand.pronunciation.maxlength,
            },
            instagram_url: {
                url: brandsValidation.create_brand.instagram_url.url,
            },
        },
    });
}

/**
 * Change the status of a brand.
 * @param {number} id - The ID of the brand to change the status of.
 */
function changeStatus(id) {
    $.ajax({
        url: `${apiUrl}/${id}/change-status`,
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            fetchDataAndPopulate();
            showToast(response.message, 'success');
        },
        error: function (xhr) {
            showToast(xhr.responseJSON.message, 'error');
        }
    });
}
