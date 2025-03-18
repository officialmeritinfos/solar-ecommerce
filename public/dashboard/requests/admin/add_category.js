const categoryRequest=function (){
    const initiateNewCategory=function (){
        //process the form submission
        $('#addCategory').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#addCategory').attr('action');
            var baseURLs='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseURL,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('.saveCategory').attr('disabled', true);
                    $("#addCategory :input").prop("readonly", true);
                    $(".saveCategory").LoadingOverlay("show",{
                        text        : "please wait ...",
                        size        : "20"
                    });
                },
                success:function(data)
                {
                    if(data.error === 'ok')
                    {
                        Swal.fire({
                            text: data.message,
                            icon: "success",
                            customClass: {
                                confirmButton: "btn btn-primary waves-effect waves-light",
                            },
                            position: "top-end",
                            timer: 3000, // Auto close after 5 seconds
                            showConfirmButton: false,
                        });
                        let category = data.data;

                        $("#category-org").append(`<option value="${category.id}" selected>${category.name}</option>`);

                        $("#parent_id").append(`<option value="${category.id}">${category.name}</option>`);

                        // Append to table
                        const rowHTML = `
                            <tr data-id="${category.id}"
                                data-name="${category.name}"
                                data-slug="${category.slug}"
                                data-description="${category.description ?? ''}"
                                data-image="${category.image_url ?? ''}"
                                data-image-path="${category.image ?? ''}"
                                data-parent_id="${category.parent_id ?? ''}"
                                data-is_active="${category.is_active ? 1 : 0}"
                                data-edit-url="${category.edit_url}"
                                data-delete-url="${category.delete_url}"
                            >
                                <td>NEW</td>
                                <td>
                                    ${category.image_url
                            ? `<img src="${category.image_url}" width="50" alt="Image">`
                            : `<span class="text-muted">No Image</span>`}
                                </td>
                                <td>${category.name}</td>
                                <td>${category.slug}</td>
                                <td>${category.parent_name || '—'}</td>
                                <td>${category.product_count || 0}</td>
                                <td>
                                    <span class="badge bg-${category.is_active ? 'success' : 'secondary'}">
                                        ${category.is_active ? 'Active' : 'Inactive'}
                                    </span>
                                </td>
                                <td>${category.created_at}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-category-btn" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-category-btn" title="Delete">
                                        <i class="fa fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        `;

                        $("#categories-table tbody").append(rowHTML);

                        //return to natural stage
                        setTimeout(function(){
                            $('.saveCategory').attr('disabled', false);
                            $(".saveCategory").LoadingOverlay("hide");

                            $('#addCategory')[0].reset();

                            $("#addCategory :input").prop("readonly", false);
                            // Close modal
                            $("#addCategoryModal").modal("hide");
                            $("#newCategoryName").val("");


                        }, 3000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Re-enable form inputs and hide loading overlay
                    $("#addCategory :input").prop("readonly", false);

                    $('.saveCategory').attr('disabled', false);
                    $(".saveCategory").LoadingOverlay("hide");

                    let errorMessage = "An unexpected error occurred. Please try again.";

                    // Handle Laravel validation errors (structured JSON response)
                    if (jqXHR.responseJSON && jqXHR.responseJSON.data && jqXHR.responseJSON.data.error) {
                        errorMessage = jqXHR.responseJSON.data.error;
                    }
                    // Handle unknown errors (fallback for anything else)
                    else if (jqXHR.responseText) {
                        errorMessage = jqXHR.responseText.trim();
                    }

                    Swal.fire({
                        text: errorMessage,
                        icon: "error",
                        customClass: {
                            confirmButton: "btn btn-danger waves-effect waves-light",
                        },
                        position: "top-end"
                    });

                }

            });
        });
    }

    return {
        init: function() {
            initiateNewCategory();
        }
    };
}();

jQuery(document).ready(function() {
    categoryRequest.init();
});

