const accountSecurityRequest = function () {
    const setupTwoFactor = function () {
        $('#twoStepsForm').on('submit.ajax', function (e) {
            e.preventDefault(); // Prevent default submission

            var baseURL = $(this).attr('action');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseURL,
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function () {
                    $('.submit').attr('disabled', true);
                    $("#twoStepsForm :input").prop("readonly", true);
                    $(".submit").LoadingOverlay("show", {
                        text: "please wait ...",
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

                        // Return to natural stage
                        setTimeout(function () {
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#twoStepsForm :input").prop("readonly", false);
                            window.location.replace(data.data.redirectTo);
                        }, 3000);
                    }
                },
                error: function (jqXHR) {
                    // Re-enable form inputs and hide loading overlay
                    $("#twoStepsForm :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");

                    let errorMessage = "An unexpected error occurred. Please try again.";

                    // Handle Laravel validation errors
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

    const updateAccountPassword = function () {
        $('#formAccountSettings').on('submit.ajax', function (e) {
            e.preventDefault(); // Prevent default submission

            var baseURL = $(this).attr('action');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseURL,
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function () {
                    $('.submit').attr('disabled', true);
                    $("#formAccountSettings :input").prop("readonly", true);
                    $(".submit").LoadingOverlay("show", {
                        text: "please wait ...",
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

                        // Return to natural stage
                        setTimeout(function () {
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#formAccountSettings :input").prop("readonly", false);
                            window.location.replace(data.data.redirectTo);
                        }, 3000);
                    }
                },
                error: function (jqXHR) {
                    // Re-enable form inputs and hide loading overlay
                    $("#formAccountSettings :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");

                    let errorMessage = "An unexpected error occurred. Please try again.";

                    // Handle Laravel validation errors
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
            setupTwoFactor();
            updateAccountPassword();
        }
    };
}();

jQuery(document).ready(function () {
    accountSecurityRequest.init();
});
