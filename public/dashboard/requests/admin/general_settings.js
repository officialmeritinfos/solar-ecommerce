const generalSettingsRequest=function (){
    const generalSettingsUpdate=function (){
        //process the form submission
        $('#generalSettingsForm').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#generalSettingsForm').attr('action');
            var baseURLs='';
            var formData = new FormData(this);

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
                    $("#generalSettingsForm :input").prop("readonly", true);
                    $(".submit").LoadingOverlay("show",{
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
                            timer: 3000, // Auto close after 3 seconds
                            showConfirmButton: false,
                        });
                        //return to natural stage
                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#generalSettingsForm :input").prop("readonly", false);
                            window.location.replace(data.data.redirectTo)
                        }, 4000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {

                    // Re-enable form inputs and hide loading overlay
                    $("#generalSettingsForm :input").prop("readonly", false);

                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");


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
            generalSettingsUpdate();
        }
    };
}();

jQuery(document).ready(function() {
    generalSettingsRequest.init();
});

