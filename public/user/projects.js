const apiUrl = "/projects";
const tableBody = $("tbody");
$(document).ready(function () {
    // Show loading message initially
    tableBody.html(tableLoader());
    fetchDataAndPopulate();
    initializeCatForm();
});

/**
 * Populate the table with the given data.
 * @param {array} datas - Array of project objects
 */
function populateTable(datas) {
    let html = "";
    if (datas.length) {
        datas.forEach(function (data) {
            const priorityClass = data.priority === 'high' ? 'danger' : data.priority === 'medium' ? 'warning' : 'sucess';
            const statusClass = data.status === 'Completed' ? 'sucess' : data.status === 'In progress' ? 'warning' : data.status === 'Pending' ? 'danger' : 'info';
            html += `
                <tr>
                    <td>
                        <div class="d-flex gap-3"></div>
                            <div class="info">
                                <p data-bs-toggle="tooltip" title="${data.name}" class="text-capitalize">${trimString(data.name, 30)}</p>
                            </div>
                        </div>
                    </td>
                    <td><span data-bs-toggle="tooltip" title="${data.user.name}" class="text-capitalize">${trimString(data.user.name, 30)}</span></td>
                    <td><span data-bs-toggle="tooltip" title="${data.product.brand.name}" class="text-capitalize">${trimString(data.product.brand.name, 30)}</span></td>
                    <td><span data-bs-toggle="tooltip" title="${data.product.name}" class="text-capitalize">${trimString(data.product.name, 30)}</span></td>
                    <td>${trimString(data.guidelines, 50)}</td>
                    <td>${trimString(data.notes, 50)}</td>
                    <td><span class="badge ${priorityClass}">${data.priority}</span></td>
                    <td><span class="badge ${statusClass}">${data.status}</span></td>
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
        html = emptyTable(message = "No Project Available");
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
                    initializeCkeditor();
                    initializeBrands();
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
            user_id: {
                required: true,
            },
            brand_id: {
                required: true,
            },
            product_id: {
                required: true,
            },
            priority: {
                required: true,
            },
            guidelines: {
                maxlength: 1000,
            },
            notes: {
                maxlength: 1000,
            },
        },
        messages: {
            name: {
                required: projectsValidation.create_project.name.required,
                minlength: projectsValidation.create_project.name.minlength,
                maxlength: projectsValidation.create_project.name.maxlength,
            },
            user_id: {
                required: projectsValidation.create_project.user_id.required,
            },
            brand_id: {
                required: projectsValidation.create_project.brand_id.required,
            },
            product_id: {
                required: projectsValidation.create_project.product_id.required,
            },
            priority: {
                required: projectsValidation.create_project.priority.required,
            },
            guidelines: {
                maxlength: projectsValidation.create_project.guidelines.maxlength,
            },
            notes: {
                maxlength: projectsValidation.create_project.notes.maxlength,
            },
        },
    });
}

function initializeCkeditor() {
    console.log("Initializing CKEditor");
    ClassicEditor.create(document.querySelector("#guidelines"), {
        ckfinder: {
            uploadUrl: "/admin/blog/upload-media",
        },
    })
}
function initializeBrands() {
    $('#brand_id').on('change', function () {
            var brandId = $(this).val();
            $.ajax({
                url: '/project/get-products-by-brand',
                type: 'GET',
                data: { brand_id: brandId },
                success: function (data) {
                    var productSelect = $('#product_id');
                    productSelect.empty();
                    $.each(data.data, function (key, value) {
                        productSelect.append('<option value="' + key + '">' + value + '</option>');
                    });
                    productSelect.trigger('change');
                }
            });
        });
}
