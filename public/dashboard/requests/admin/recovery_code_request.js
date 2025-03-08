$(document).ready(function () {
    $("#verifyButton").on("click", function () {
        let password = $("#recoveryPassword").val();
        let recoveryUrl = $(this).attr("data-recovery-url");

        if (!password) {
            Swal.fire({
                text: "Please enter your OTP.",
                icon: "warning",
                customClass: { confirmButton: "btn btn-primary waves-effect waves-light" },
                position: "top-end",
                timer: 3000,
                showConfirmButton: false,
            });
            return;
        }

        // AJAX request to verify password
        $.ajax({
            url: recoveryUrl,
            type: "POST",
            data: JSON.stringify({ password: password }),
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            beforeSend: function () {
                $("#verifyButton").text("Verifying...").prop("disabled", true);
            },
            success: function (response) {
                $("#recoveryContainer").removeClass("d-none");
                $("#recoveryPhrase").text(response.recovery_phrase);
                $("#recoveryDate").text(new Date().toLocaleString());

                Swal.fire({
                    text: response.message,
                    icon: "success",
                    customClass: { confirmButton: "btn btn-primary waves-effect waves-light" },
                    position: "top-end",
                    timer: 3000,
                    showConfirmButton: false,
                });
            },
            error: function (xhr) {
                let errorMsg = xhr.responseJSON?.message || "Incorrect password! Please try again.";
                Swal.fire({
                    text: errorMsg,
                    icon: "error",
                    customClass: { confirmButton: "btn btn-primary waves-effect waves-light" },
                    position: "top-end",
                    timer: 3000,
                    showConfirmButton: false,
                });
            },
            complete: function () {
                $("#verifyButton").text("Reveal Recovery Phrase").prop("disabled", false);
            }
        });
    });

    // Copy Recovery Phrase to Clipboard
    $("#copyPhrase").on("click", function () {
        let recoveryText = $("#recoveryPhrase").text();
        if (recoveryText) {
            navigator.clipboard.writeText(recoveryText).then(() => {
                Swal.fire({
                    text: "Recovery phrase copied!",
                    icon: "success",
                    customClass: { confirmButton: "btn btn-primary waves-effect waves-light" },
                    position: "top-end",
                    timer: 3000,
                    showConfirmButton: false,
                });
            }).catch(err => {
                Swal.fire({
                    text: "Failed to copy!",
                    icon: "error",
                    customClass: { confirmButton: "btn btn-primary waves-effect waves-light" },
                    position: "top-end",
                    timer: 3000,
                    showConfirmButton: false,
                });
                console.error("Failed to copy: ", err);
            });
        }
    });

    // Download Recovery Phrase as a Text File
    $("#downloadPhrase").on("click", function () {
        let recoveryText = $("#recoveryPhrase").text();
        if (!recoveryText) {
            Swal.fire({
                text: "No recovery phrase found!",
                icon: "warning",
                customClass: { confirmButton: "btn btn-primary waves-effect waves-light" },
                position: "top-end",
                timer: 3000,
                showConfirmButton: false,
            });
            return;
        }

        let blob = new Blob([recoveryText], { type: "text/plain" });
        let link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = "Recovery_Phrase.txt";
        link.click();

        Swal.fire({
            text: "Recovery phrase downloaded successfully.",
            icon: "success",
            customClass: { confirmButton: "btn btn-primary waves-effect waves-light" },
            position: "top-end",
            timer: 3000,
            showConfirmButton: false,
        });
    });
});
