const apiUrl = "/products";
const tableBody = $("tbody");
$(document).ready(function () {
    // Show loading message initially
    tableBody.html(tableLoader());
    fetchDataAndPopulate();
    initializeCatForm();
});
/**
 * Populate the table with the given data.
 * @param {array} datas - Array of product objects
 */
function populateTable(datas) {
    let html = "";
    if (datas.length) {
        datas.forEach(function (data) {
            html += `
                <tr>
                    <td>
                        <div class="d-flex gap-3"></div>
                            <div class="info">
                                <p data-bs-toggle="tooltip" title="${data.name}" class="text-capitalize">${trimString(data.name, 30)}</p>
                            </div>
                        </div>
                    </td>
                    <td><span data-bs-toggle="tooltip" title="${data.brand.name}" class="text-capitalize">${trimString(data.brand.name, 30)}</span></td>
                    <td>${trimString(data.description, 50)}</td>
                    <td><a class="change-status" href="product/${
                         data.id
                     }/change-status" data-bs-toggle="tooltip" title="Click to ${
                data.service_status == 1 ? "Pending" : "Completed"
            }" href="javascript:void(0)">${
                data.service_status == "1"
                    ? "<span class='badge sucess'>Completed</span>"
                    : "<span class='badge warning'>Pending</span>"
            }</a></td>
                    <td>
                        <div class="table-action">
                            <a data-bs-toggle="tooltip" title="View ${trimString(data.name, 15)}" class="cat-from-button" href="${apiUrl+'/'+data.id}"><span class="view"><span class="iconify" data-icon="iconamoon:eye" data-inline="false"></span></span></a>

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
        html = emptyTable(message = "No Product Available");
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
                    deleteImage();
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
            brand_id: {
                required: true,
            },
            images: {
                required: !isEdit,
            },
            description: {
                maxlength: 1000,
                required: true,

            },
        },
        messages: {
            name: {
                required: productsValidation.create_product.name.required,
                minlength: productsValidation.create_product.name.minlength,
                maxlength: productsValidation.create_product.name.maxlength,
            },
            brand_id: {
                required: productsValidation.create_product.brand_id.required,
            },
            image: {
                required: productsValidation.create_product.image.required,
                extension: productsValidation.create_product.image.extension,
            },
            description: {
                maxlength: productsValidation.create_product.description.maxlength,
                required: productsValidation.create_product.description.required,
            },
        },
    });
}


/**
 * Delete an image.
 */
function deleteImage() {
    $(".delete-image").off("click").click(function (e) {
        e.preventDefault();
        let url = $(this).attr("href");
        $.ajax({
            url: url,
            method: "DELETE",
            dataType: "json",
            success: function (response) {
                toastr.success(
                    "Image deleted successfully",
                    "Success",
                    {
                        iconClass: "success",
                        timeOut: 2000,
                    }
                );

                $(e.target).closest("div").remove();
            },
            error: function (xhr) {
         toastr.error(xhr.responseJSON.message);
            }
        });
    });
}
