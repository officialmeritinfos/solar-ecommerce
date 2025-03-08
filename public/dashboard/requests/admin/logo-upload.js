$(document).ready(function () {
    $('#upload').change(function () {
        let fileInput = this;
        let formData = new FormData();
        let file = fileInput.files[0];

        if (!file) return;

        let uploadUrl = $(this).data('logo-url'); // Get upload URL from data attribute

        // Validate File Type
        let allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/ico', 'image/svg'];
        if (!allowedTypes.includes(file.type)) {
            Swal.fire({
                text: "Invalid file type. Please upload JPG, PNG, ICO, or SVG.",
                icon: "error",
                customClass: { confirmButton: "btn btn-danger" },
                position: "top-end",
                timer: 3000,
                showConfirmButton: false,
            });
            return;
        }

        formData.append('logo', file); // Append file to FormData
        formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // CSRF Token

        // Show loading state
        $('#uploadedAvatar').css('opacity', '0.5');

        // AJAX Request to Upload Image
        $.ajax({
            url: uploadUrl,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function () {
                Swal.fire({
                    text: "Uploading...",
                    icon: "info",
                    customClass: { confirmButton: "btn btn-info" },
                    position: "top-end",
                    timer: 2000,
                    showConfirmButton: false,
                });
            },
            success: function (response) {
                if (response.error === 'ok') {
                    let newImageUrl = response.data.logo_url; // Get the new image URL

                    // Update the image source
                    $('#uploadedAvatar').attr('src', newImageUrl).css('opacity', '1');

                    Swal.fire({
                        text: "Logo updated successfully!",
                        icon: "success",
                        customClass: { confirmButton: "btn btn-primary" },
                        position: "top-end",
                        timer: 3000,
                        showConfirmButton: false,
                    });
                }
            },
            error: function (jqXHR) {
                $('#uploadedAvatar').css('opacity', '1'); // Reset opacity
                let errorMessage = "Upload failed. Please try again.";

                if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                    errorMessage = jqXHR.responseJSON.message;
                }

                Swal.fire({
                    text: errorMessage,
                    icon: "error",
                    customClass: { confirmButton: "btn btn-danger" },
                    position: "top-end",
                });
            }
        });
    });
});
