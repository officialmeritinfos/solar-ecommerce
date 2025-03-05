<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
        }
        p {
            font-size: 16px;
            color: #555;
            line-height: 1.5;
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
        .button:hover {
            background-color: #0056b3;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
        @media screen and (max-width: 600px) {
            .container {
                width: 90%;
                padding: 15px;
            }
            p {
                font-size: 14px;
            }
            .button {
                font-size: 14px;
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Email Verification</h1>
    <p>Hi {{ $user->name }},</p>
    <p>Thank you for signing up. Please verify your email address by clicking the button below.</p>
    <a href="{{ $verificationUrl }}" class="button">Verify Email</a>
    <p>If you did not create an account, no further action is required.</p>
    <p class="footer">This link expires in 24 hours.</p>
</div>
</body>
</html>
