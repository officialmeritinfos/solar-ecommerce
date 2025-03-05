<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Attempt Notification</title>
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
            color: #333;
        }
        .content {
            margin: 20px 0;
        }
        .info-box {
            background: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
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
            background: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>New Login Attempt on Your Account</h2>
    <p>Dear {{ $name }},</p>

    <p>We detected a new login attempt on your account:</p>

    <div class="info-box">
        <strong>IP Address:</strong> {{ $ipAddress }} <br>
        <strong>Location:</strong> {{ $location }} <br>
        <strong>Device:</strong> {{ $device }} <br>
        <strong>Date & Time:</strong> {{ $dateTime }}
    </div>

    <p>If this was you, no further action is required.</p>

    <p>If you do not recognize this activity, please <a href="{{ route('account-recovery') }}" class="btn">Reset Your Password</a> immediately.</p>

    <div class="footer">
        <p>If you have any questions, contact our support team.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div>
</body>
</html>
