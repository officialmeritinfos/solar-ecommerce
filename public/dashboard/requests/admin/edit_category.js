const editCategoryRequest = function () {
    const initiateEditCategory = function () {
        $('.update-category-btn').on("click", function (e) {
            e.preventDefault();

            let form = $("#editCategoryForm");
            let baseURL = form.attr('action');
            let formData = new FormData(form[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseURL,
                method: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                beforeSend: function () {
                    $('.update-category-btn').attr('disabled', true);
                    $("#editCategoryForm :input").prop("readonly", true);
                    $(".update-category-btn").LoadingOverlay("show", {
                        text: "Updating...",
                        size: "20"
                    });
                },
                success: function (data) {
                    if (data.error === 'ok') {
                        Swal.fire({
                            text: data.message,
                            icon: "success",
                            customClass: {
                                confirmButton: "btn btn-primary waves-effect waves-light",
                            },
                            position: "top-end",
                            timer: 3000,
                            showConfirmButton: false,
                        });

                        setTimeout(function () {
                            $('.update-category-btn').attr('disabled', false);
                            $("#editCategoryForm :input").prop("readonly", false);
                            $(".update-category-btn").LoadingOverlay("hide");

                            window.location.reload();
                        }, 3000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#editCategoryForm :input").prop("readonly", false);
                    $('.update-category-btn').attr('disabled', false);
                    $(".update-category-btn").LoadingOverlay("hide");

                    let errorMessage = "An unexpected error occurred. Please try again.";

                    if (jqXHR.responseJSON && jqXHR.responseJSON.data && jqXHR.responseJSON.data.error) {
                        errorMessage = jqXHR.responseJSON.data.error;
                    } else if (jqXHR.responseText) {
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
    };

    return {
        init: function () {
            initiateEditCategory();
        }
    };
}();

jQuery(document).ready(function () {
    editCategoryRequest.init();
});
