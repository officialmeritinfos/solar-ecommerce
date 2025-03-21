<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Changed Successfully</title>
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
    <h2>Password Changed Successfully</h2>
    <p>Dear {{ $name }},</p>

    <p>Your password has been successfully changed.</p>

    <div class="info-box">
        <strong>IP Address:</strong> {{ $ipAddress }} <br>
        <strong>Location:</strong> {{ $location }} <br>
        <strong>Device:</strong> {{ $device }} <br>
        <strong>Date & Time:</strong> {{ $dateTime }}
    </div>

    <p>If you made this change, you can ignore this email.</p>

    <p>If this wasn’t you, reset your password immediately.</p>

    <p>
        <a href="{{ route('account-recovery') }}" class="btn">Reset Password</a>
    </p>

    <div class="footer">
        <p>If you have any concerns, contact our support team.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div>
</body>
</html>
