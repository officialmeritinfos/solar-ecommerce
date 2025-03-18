const createCouponRequest = function () {
    const initiateCreateCoupon = function () {
        $('.submit').on("click", function (e) {
            e.preventDefault();

            let form = $("#createCouponForm");
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
                    $('.submit').attr('disabled', true);
                    $("#createCouponForm :input").prop("readonly", true);
                    $(".submit").LoadingOverlay("show", {
                        text: "Saving...",
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
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#createCouponForm :input").prop("readonly", false);

                            window.location.replace(data.data.redirectTo || window.location.href);
                        }, 3000);
                    }
                },

                error: function (jqXHR, textStatus, errorThrown) {
                    $("#createCouponForm :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");

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
            initiateCreateCoupon();
        }
    };
}();

jQuery(document).ready(function () {
    createCouponRequest.init();
});
