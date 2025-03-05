<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication Disabled</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #d9534f;
        }
        .content {
            margin: 20px 0;
        }
        .info-box {
            background: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #888;
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #d9534f;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
        .btn:hover {
            background: #c9302c;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Two-Factor Authentication Disabled</h2>
    <p>Dear {{ $name }},</p>

    <p>We noticed that your two-factor authentication (2FA) has been disabled for your account.</p>

    <div class="info-box">
        <strong>IP Address:</strong> {{ $ipAddress }} <br>
        <strong>Location:</strong> {{ $location }} <br>
        <strong>Device:</strong> {{ $device }} <br>
        <strong>Date & Time:</strong> {{ $dateTime }}
    </div>

    <p>If you disabled 2FA, you can ignore this email.</p>

    <p>If this wasn’t you, we strongly recommend re-enabling 2FA and updating your password immediately.</p>

    <p>
        <a href="{{ route('login') }}" class="btn">Secure Your Account</a>
    </p>

    <div class="footer">
        <p>If you have any questions, contact our support team.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div>
</body>
</html>
