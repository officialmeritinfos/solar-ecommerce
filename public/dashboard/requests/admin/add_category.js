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

                        //return to natural stage
                        setTimeout(function(){
                            $('.saveCategory').attr('disabled', false);
                            $(".saveCategory").LoadingOverlay("hide");

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

