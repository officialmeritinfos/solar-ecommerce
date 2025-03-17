const publishPostRequest = function () {
    const initiatePublishPost = function () {
        //process the form submission
        $('.submit').on("click",function(e) {
            e.preventDefault();
            var baseURL = $('#newPost').attr('action');
            var baseURLs='';
            let form = $("#newPost");
            var formData = new FormData(form[0]);


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseURL,
                method: "POST",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType:"json",
                beforeSend:function(){
                    $('.submit').attr('disabled', true);
                    $("#newPost :input").prop("readonly", true);
                    $(".submit").LoadingOverlay("show",{
                        text        : "please wait ...",
                        size        : "20"
                    });
                    $(".saveAsDraft").attr('disabled',true).text("a moment...");
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
                            timer: 3000, // Auto close after 3 seconds
                            showConfirmButton: false,
                        });
                        //return to natural stage
                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#newPost :input").prop("readonly", false);
                            window.location.replace(data.data.redirectTo)
                        }, 5000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Re-enable form inputs and hide loading overlay
                    $("#newPost :input").prop("readonly", false);

                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");
                    $(".saveAsDraft").attr('disabled',false).text("Save draft");


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
    };

    return {
        init: function () {
            initiatePublishPost();
        }
    };
}();

jQuery(document).ready(function () {
    publishPostRequest.init();
});
