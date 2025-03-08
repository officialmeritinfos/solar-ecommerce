<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Two-Factor Authentication Enabled</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        p {
            font-size: 14px;
            line-height: 1.6;
            color: #555;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            margin: 20px 0;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }
        .footer {
            font-size: 12px;
            text-align: center;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Two-Factor Authentication Activated</h2>

    <p>Dear {{ $user->name }},</p>

    <p>We wanted to let you know that **Two-Factor Authentication (2FA)** has been successfully enabled on your account.</p>

    <p>
        This adds an extra layer of security, requiring a verification code from your authenticator app whenever you sign in.
    </p>

    <p>If this was you, no further action is required. If you did not enable 2FA, you can disable it using the link below:</p>

    <!-- Disable 2FA Signed URL -->
    <a href="{{ $disable2FALink }}" class="button">Disable Two-Factor Authentication</a>

    <p><strong>Important:</strong> This link is valid for <b>5 Years</b>. If you do not take action within this period, you will need to manually disable 2FA from your account settings.</p>

    <p>If you have any questions, please contact our support team.</p>

    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div>

</body>
</html>
