<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .header {
            background-color: #3490dc;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .body {
            padding: 30px;
            color: #333;
        }
        .footer {
            text-align: center;
            padding: 15px;
            background-color: #f0f0f0;
            font-size: 12px;
            color: #777;
        }
        @media only screen and (max-width: 600px) {
            .container {
                width: 95%;
                margin: 10px auto;
            }
            .body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>{{ $title }}</h1>
    </div>
    <div class="body">
        {!! $content !!}
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
</div>
</body>
</html>
