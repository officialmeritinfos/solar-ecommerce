<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageName }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @include('general_css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset($web->favicon) }}" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 500px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .message {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }
        .btn-resend {
            margin-top: 10px;
        }
        .countdown {
            font-size: 14px;
            color: #999;
            display: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Email Verification Required</h2>
    <p class="message">We've sent a verification email to your registered email address. Please check your inbox and click the link to verify your account.</p>
    <button id="resend-btn" class="btn btn-primary btn-resend">Resend Verification Email</button>
    <p id="countdown-text" class="countdown">You can request again in <span id="countdown">60</span> seconds.</p>
    <p class="text-muted mt-3">If you haven't received the email, click the button above to resend.</p>
</div>

@include('general_js')
<script>
    $(document).ready(function() {
        let countdown = 60;
        let countdownInterval;

        function startCountdown() {
            $("#resend-btn").prop("disabled", true);
            $("#countdown-text").show();

            countdownInterval = setInterval(function() {
                countdown--;
                $("#countdown").text(countdown);

                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    $("#countdown-text").hide();
                    $("#resend-btn").prop("disabled", false).text("Resend Verification Email");
                }
            }, 1000);
        }

        $("#resend-btn").click(function() {
            $(this).prop("disabled", true).text("Processing...");
            $.ajax({
                url: "{{ route('verification.resend') }}",
                method: "POST",
                data: { _token: "{{ csrf_token() }}" },
                success: function(response) {
                    Swal.fire({
                        text: 'A new verification email has been sent.',
                        icon: 'success',
                        customClass: {
                            confirmButton: 'btn btn-primary waves-effect waves-light'
                        },
                        buttonsStyling: false,
                        position: "top-end"
                    });
                    countdown = 60;
                    startCountdown();
                },
                error: function(jqXHR, textStatus, errorThrown) {
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
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-primary waves-effect waves-light'
                        },
                        buttonsStyling: false,
                        position: "top-end"
                    });
                    $("#resend-btn").prop("disabled", false).text("Resend Verification Email");
                }
            });
        });

        // Initialize the countdown if the button was recently clicked
        if (localStorage.getItem("resendCooldown")) {
            let lastClicked = parseInt(localStorage.getItem("resendCooldown"));
            let now = Math.floor(Date.now() / 1000);
            let remaining = lastClicked + 60 - now;

            if (remaining > 0) {
                countdown = remaining;
                startCountdown();
            }
        }

        $("#resend-btn").click(function() {
            localStorage.setItem("resendCooldown", Math.floor(Date.now() / 1000));
        });
    });
</script>

</body>
</html>
