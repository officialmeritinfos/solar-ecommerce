const registerRequest=function (){
    const initiateRegistration=function (){
        //process the form submission
        $('#formAuthentication').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#formAuthentication').attr('action');
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
                    $('.submit').attr('disabled', true);
                    $("#formAuthentication :input").prop("readonly", true);
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
                            $("#formAuthentication :input").prop("readonly", false);
                            window.location.replace(data.data.redirectTo)
                        }, 5000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {

                    Swal.fire({
                        text: jqXHR.responseJSON.data.error,
                        icon: "error",
                        customClass: {
                            confirmButton: "btn btn-danger waves-effect waves-light",
                        },
                        position: "top-end"
                    });

                    // Re-enable form inputs and hide loading overlay
                    $("#formAuthentication :input").prop("readonly", false);

                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");

                    grecaptcha.reset();
                }

            });
        });
    }

    return {
        init: function() {
            initiateRegistration();
        }
    };
}();

jQuery(document).ready(function() {
    registerRequest.init();
});

