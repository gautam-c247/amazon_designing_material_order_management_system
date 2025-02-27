const apiUrl = "/admin/category";
const tableBody = $("tbody");
$(document).ready(function () {
    // Show loading message initially
    tableBody.html(tableLoader());
    fetchDataAndPopulate();
    initializeCatForm();
});
/**
 * Populate the table with the given data.
 * @param {array} datas - Array of category objects
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
                                <p data-bs-toggle="tooltip" title="${
                                    data.name
                                }" class="text-capitalize">${trimString(
                data.name,
                30
            )}</p>
                            </div>
                        </div>
                    </td>

                    <td><span data-bs-toggle="tooltip" title="${
                        data.parent?.name ? data.parent.name : "N/A"
                    }" class="text-capitalize">${
                data.parent?.name ? trimString(data.parent.name, 30) : "N/A"
            }</span> </td>
                   <td><a class="change-status" href="category/${
                       data.id
                   }/change-status" data-bs-toggle="tooltip" title="Click to ${
                data.status == "1" ? "Inactive" : "Active"
            }" href="javascript:void(0)">${
                data.status == "1"
                    ? "<span class='badge sucess'>Active</span>"
                    : "<span class='badge warning'>Inactive</span>"
            }</a></td>
            <td>${data?.created_at ? new Date(data.created_at).toISOString().split('T')[0] : "N/A"}</td>
                    <td>
                        <div class="table-action">
                            <a data-bs-toggle="tooltip" title="Edit ${trimString(
                                data.name,
                                15
                            )}" class="cat-from-button" href="/admin/category/${
                data.id
            }/edit"><span class="edit">
                                <span class="iconify" data-icon="lucide:edit" data-inline="false"></span>
                            </span></a>
                            <a  data-bs-toggle="tooltip" title="Delete ${trimString(
                                data.name,
                                15
                            )}" href="javascript:void(0)" onclick="deleteData(${data.id}, '${trimString(
                data.name,
                15
            )}')"> <span class="delete">
                                <span class="iconify" data-icon="mi:delete" data-inline="false"></span>
                            </span></a>
                        </div>
                    </td>
                </tr>
            `;
        });
    } else {
        html = emptyTable(message = "No Category Available");    }
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
                    submitDataForm();
                    $("#globalModal").modal("show");
                    implementSelect2OnModel();
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
    $(".dataForm").validate({
        rules: {
            name: {
                required: true,
                maxlength: 100,
                minlength: 3,
                noSpecialChars: true,
            },
        },
        messages: {
            name: {
                required: categoriesValidation.create_category.name.required,
                maxlength: categoriesValidation.create_category.name.maxlength,
                minlength: categoriesValidation.create_category.name.minlength,
            },
        },
    });
}
