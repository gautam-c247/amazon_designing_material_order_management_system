const tableBottom = $(".table-bottom");
let debounceTimeout;
const pagination = tableBottom.find(".pagination");
const goToPage = tableBottom.find(".field select").first();
const perPage = tableBottom.find(".field select").last();
const search = document.getElementById("search");
const paginationLine = tableBottom.find(".pagination-line");
let queryString = "";
/**
 * Populates the table controls with the given metadata.
 *
 * @param {object} meta Metadata object with the following properties:
 *   - total: Total number of records
 *   - from: Starting record number
 *   - to: Ending record number
 *   - current_page: Current page number
 *   - last_page: Last page number
 *   - per_page: Number of records per page
 */
function populateControls(meta) {
    // Clear existing content
    pagination.html("");
    goToPage.html("");
    perPage.html("");
    paginationLine.html("");

    paginationLine.append(`
            Showing ${meta.from} to ${meta.to} of ${meta.total} entries
    `);

    if (meta.total > 0) {
        pagination.append(`
            <li><span class="prev" ${
                meta.current_page === 1 ? "disabled" : ""
            } data-page="${meta.current_page - 1}">
                <span class="iconify" data-icon="mingcute:arrow-left-line" data-inline="false"></span>
            </span></li>
        `);

        // For pagination numbers
        const startPage = Math.max(meta.current_page - 1, 1); // Adjust this logic for page number range
        const endPage = Math.min(meta.current_page + 1, meta.last_page); // Adjust this logic for page number range

        for (let page = startPage; page <= endPage; page++) {
            pagination.append(`
                <li class="${page === meta.current_page ? "active" : ""}">
                    <span>${page.toString().padStart(2, "0")}</span>
                </li>
            `);
        }
        pagination.append(`
            <li><span class="next cursor-pointer" ${
                meta.current_page === meta.last_page ? "disabled" : ""
            } data-page="${meta.current_page + 1}">
                <span class="iconify" data-icon="mingcute:arrow-right-line" data-inline="false"></span>
            </span></li>
        `);
    }

    // Populate "Go to page" options
    for (let i = 1; i <= meta.last_page; i++) {
        goToPage.append(
            `<option value="${i}" ${
                i === meta.current_page ? "selected" : ""
            }>${i}</option>`
        );
    }

    // Populate "Per Page" options
    [10, 20, 30, 40, 100].forEach((option) => {
        perPage.append(
            `<option value="${option}" ${
                option === meta.per_page ? "selected" : ""
            }>${option}</option>`
        );
    });

    pagination.find(".prev").on("click", function () {
        if (!$(this).hasClass("disabled")) {
            const currentPage = parseInt(meta.current_page);
            const prevPage = currentPage - 1;
            fetchDataAndPopulate(
                prevPage,
                perPage.val(),
                search.value,
                $(this).attr("data-order"),
                $(this).attr("data-order-by"),
                queryString
            );
        }
    });

    pagination.find(".next").on("click", function () {
        if (!$(this).hasClass("disabled")) {
            const currentPage = parseInt(meta.current_page);
            const nextPage = currentPage + 1;
            fetchDataAndPopulate(
                nextPage,
                perPage.val(),
                search.value,
                $(this).attr("data-order"),
                $(this).attr("data-order-by"),
                queryString
            );
        }
    });

    // Handle "Go to page" change
    goToPage.off("change").on("change", function () {
        const selectedPage = $(this).val();
        fetchDataAndPopulate(
            selectedPage,
            perPage.val(),
            search.value,
            $(this).attr("data-order"),
            $(this).attr("data-order-by"),
            queryString
        );
    });

    // Handle "Per Page" change
    perPage.off("change").on("change", function () {
        const newPerPage = $(this).val();
        const currentPage = parseInt(goToPage.val(), 10);
        const totalPages = Math.ceil(meta.total / newPerPage);

        if (currentPage > totalPages) {
            goToPage.val(totalPages); // Set the current page to the last valid page
        }

        // Call the function to fetch data with the adjusted page and perPage
        fetchDataAndPopulate(
            goToPage.val(),
            newPerPage,
            search.value,
            $(this).attr("data-order"),
            $(this).attr("data-order-by"),
            queryString
        );
    });

    search.oninput = () => {
        clearTimeout(debounceTimeout); // Clear the previous timeout
        if (search.value.length > 2 || search.value.length === 0) {
            debounceTimeout = setTimeout(() => {
                fetchDataAndPopulate(
                    1,
                    perPage.val(),
                    search.value,
                    $(this).attr("data-order"),
                    $(this).attr("data-order-by"),
                    queryString
                );
            }, 500); // Set a new timeout
        }
    };
}

/**
 * Capitalize the first letter of a string.
 * @param {string} str the string to capitalize
 * @returns {string} the capitalized string
 */
function capitalize(str) {
    return str && str.charAt(0).toUpperCase() + str.slice(1);
}
$(document).ready(function () {
    $(".table-sort")
        .off("click")
        .on("click", function () {
            let currentOrder = $(this).attr("data-order");
            let newOrder = currentOrder === "asc" ? "desc" : "asc";

            $(this).attr("data-order", newOrder);
            if (newOrder === "desc") {
                $(this)
                    .find(".sort-icon")
                    .attr("src", "/admin/images/sort-icon.svg");
            } else {
                $(this)
                    .find(".sort-icon")
                    .attr("src", "/admin/images/sort-icon-flip.svg");
            }
            // Update the data attribute
            fetchDataAndPopulate(
                1,
                perPage.val(),
                search.value,
                $(this).attr("data-order-by"),
                $(this).attr("data-order"),
                queryString,
                false
            );
        });
});

/**
 * Fetches data from the API and populates the table with it.
 *
 * @param {number} [page=1] Page number to fetch.
 * @param {number} [perPage=40] Number of records to fetch per page.
 * @param {string} [search=""] Search query.
 * @param {string} [order_by="updated_at"] Field to order the records by.
 * @param {string} [order="desc"] Order to fetch the records in.
 * @param {string} [query=""] Additional query string parameters.
 * @param {boolean} [loader=true] Show a loader while fetching data.
 */
function fetchDataAndPopulate(
    page = 1,
    perPage = 40,
    search = "",
    order_by = "updated_at",
    order = "desc",
    query = "",
    loader = true
) {
    if (loader) {
        $(".tooltip").hide();
        tableBody.html(tableLoader());
    }
    $.get({
        url: `${apiUrl}?page=${page}&per_page=${perPage}&search=${search}&order_by=${order_by}&order=${order}&${query}`,
        dataType: "json", // Ensure the response is treated as JSON
        headers: {
            Accept: "application/json", // Explicitly request a JSON response
        },
        success: function (response) {
            if (response.data) {
                populateTable(response.data.data); // Populate table with the correct data
                populateControls(response.data);
                if (response.data.data.length == 0) {
                    $(".table-bottom").hide();
                } else {
                    $(".table-bottom").show();
                }
                reinitializeTooltips();
            }
        },
        error: function (xhr, status, error) {
            tableBody.html(emptyTable()); // Display empty table when error occurs
        },
    });
}
/**
 * Shows a confirmation dialog to delete the given resource.
 *
 * @param {Number} id
 * @param {String} name
 */
function deleteData(id, name) {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete " + name,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: window.location.href + "/" + id,
                method: "DELETE",
                success: function (data) {
                    toastr.success(data.message, "Success", {
                        iconClass: "success",
                    });
                    reloadTable();
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.error, "Error", {
                        iconClass: "error",
                        timeOut: 2000,
                    });
                },
            });
        }
    });
}

/**
 * Handles submitting the data form. When the form is submitted, it sends the form data to the server
 * via an AJAX request. If the request is successful, it closes the modal and displays a success
 * message. If there are validation errors, it displays them below the form fields. If there is an
 * unexpected error, it displays an error message.
 */
function submitDataForm() {
    $(".dataForm").submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        if ($(this).valid()) {
            $.ajax({
                url: $(this).attr("action"),
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $("#globalModal").modal("hide");
                    toastr.success(response.message, "Success", {
                        iconClass: "success",
                    });
                    reloadTable();
                },
                error: function (xhr) {
                    // Clear any existing validation errors
                    $(".invalid-feedback").remove();
                    $(".is-invalid").removeClass("is-invalid");

                    // Check if there are validation errors
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        // Loop through the errors and display them
                        for (let field in errors) {
                            let input = $(`[name="${field}"]`);
                            input.addClass("is-invalid error");

                            // Create error message element and append it
                            let errorMessage = `<span class="error server-error invalid-feedback">${errors[field][0]}</span>`;
                            input.after(errorMessage);
                        }
                    } else {
                        alert(
                            "An unexpected error occurred. Please try again."
                        );
                    }
                },
            });
        }
    });
}
/**
 * Reloads the table with the most recent data from the server. This function
 * is used after performing an action that affects the data, such as creating
 * or deleting a record. The function waits for 500 milliseconds to ensure
 * that the server has time to process the request before reloading the table.
 */
function reloadTable() {
    setTimeout(() => {
        fetchDataAndPopulate();
    }, 500);
}
/**
 * Initializes Select2 plugin on elements with the "js-select2" class.
 *
 * @param {string} id - Identifier for the model (not used in the function).
 *
 * The function applies the Select2 plugin to elements with the "js-select2" class,
 * configuring options such as closing the dropdown on select, setting a placeholder,
 * and defining the dropdown parent. It also dynamically sets the placeholder for
 * the search input field within the dropdown when options are selected or when
 * the dropdown is opened.
 */

function implementSelect2OnModel(id) {
    $(".js-select2").each(function () {
        $(this).select2({
            closeOnSelect: true,
            placeholder: "Select an option",
            dropdownParent: $(this).parent(),
        });
    });

    // Set placeholder dynamically when no options are selected
    $(".js-select2").on("change", function () {
        let searchInput = $(".select2-search__field");
        searchInput.attr("placeholder", "Type to search...");
    });

    // Handle placeholder for search input inside dropdown when opened
    $(".js-select2").on("select2:open", function () {
        let searchInput = $(".select2-container--open .select2-search__field");
        searchInput.attr("placeholder", "Type to search...");
    });
}
/**
 * Generates an HTML string for a loading spinner, used to indicate that table data is being loaded.
 * The spinner is placed inside a table row with a colspan of 12.
 *
 * @return {string} The HTML string for the loading spinner row.
 */

function tableLoader() {
    return `<tr><td colspan='12'> <div class='listing-loader'>
    <div class='spinner'></div>
  </div></td></tr>`;
}
/**
 * Returns an empty table row with an empty list placeholder.
 *
 * @return {string}
 */
function emptyTable(message = "Empty List") {
    return ` <tr>
    <td colspan="12">
      <div class="empty-box text-center">
        <img src="/admin/images/empty-list.svg" alt="no-data" class="my-3">
        <div class="content">
           <h5 class="m-0">${message}</h5>
        </div>
      </div>
    </td>
  </tr>`;
}
function trimString(str, num) {
    if (!str) return ""; // Handle null or undefined values
    return str.length > num ? str.slice(0, num) + "..." : str;
}

/**
 * Trigger a confirmation dialog when the user clicks on a "change status" button.
 * If confirmed, make a POST request to the href of the button.
 * If the request is successful, show a success toast and reload the table.
 * If the request fails, show an error toast.
 */
function triggerChangeStatus() {
    $(".change-status").click(function (e) {
        e.preventDefault();
        let href = $(this).attr("href");
        Swal.fire({
            title: "Are you sure?",
            text: "You want to change the status?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, change it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(href)
                    .done(function (data) {
                        toastr.success(
                            "Status changed successfully",
                            "Success",
                            {
                                iconClass: "success",
                                timeOut: 2000,
                            }
                        );
                        reloadTable();
                    })
                    .fail(function (xhr) {
                        toastr.error("Failed to change status", "Error", {
                            iconClass: "error",
                            timeOut: 2000,
                        });
                    });
            }
        });
    });
}

$(document).ready(function () {
    $("#filterForm").submit(function (e) {
        e.preventDefault();
        const filterForm = document.getElementById("filterForm");
        const formData = new FormData(filterForm);

        // Convert FormData to a query string
        queryString = new URLSearchParams(formData).toString();
        const hasValues = Array.from(formData.entries()).some(
            ([key, value]) => value.trim() !== ""
        );
        if (hasValues) {
            fetchDataAndPopulate(
                1,
                perPage.val(),
                search.value,
                $(this).attr("data-order"),
                $(this).attr("data-order-by"),
                queryString
            );
        }
    });
});
/**
 * Resets the filter form and fetches data accordingly.
 *
 * This function clears the query string and resets the filter form
 * to its initial state. It checks if the form has any non-empty values,
 * and if so, it triggers data fetching and populates accordingly. It also
 * resets all select2 elements in the form.
 */

function resetFilter() {
    queryString = "";
    const filterForm = document.getElementById("filterForm");
    const formData = new FormData(filterForm);
    const hasValues = Array.from(formData.entries()).some(
        ([key, value]) => value.trim() !== ""
    );
    if (hasValues) {
        fetchDataAndPopulate();
    }
    $("#filterForm").trigger("reset");
    $("#filterForm .js-select2").val(null).trigger("change");
}

// Initialize the function
function reinitializeTooltips() {
    let tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        initializeTooltip(tooltipTriggerEl);
        disposeTooltip(tooltipTriggerEl);
    });
}
// Re-populate pagination controls

