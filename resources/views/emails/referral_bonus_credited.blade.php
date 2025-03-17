<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Referral Bonus Credited</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4;">
<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" style="padding: 20px 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" style="background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); font-family: Arial, sans-serif;">
                <!-- Header -->
                <tr>
                    <td bgcolor="#0d6efd" align="center" style="padding: 30px;">
                        <h1 style="color: #ffffff; margin: 0; font-size: 24px;">Referral Bonus Credited</h1>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding: 30px;">
                        <p style="font-size: 16px; margin-bottom: 20px;">Hi {{ $affiliate->name }},</p>

                        <p style="font-size: 16px; margin-bottom: 15px;">
                            We’re excited to let you know that your account has been topped up with a referral bonus!
                        </p>

                        <table style="width: 100%; margin: 20px 0; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 10px; border: 1px solid #eee;"><strong>Bonus Type:</strong></td>
                                <td style="padding: 10px; border: 1px solid #eee;">Referral Bonus</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border: 1px solid #eee;"><strong>Amount Credited:</strong></td>
                                <td style="padding: 10px; border: 1px solid #eee;">{{ getCurrencySign() }}{{ number_format($amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border: 1px solid #eee;"><strong>New Balance:</strong></td>
                                <td style="padding: 10px; border: 1px solid #eee;">{{ getCurrencySign() }}{{ number_format($affiliate->balance, 2) }}</td>
                            </tr>
                        </table>

                        @if (!empty($note))
                            <p style="font-size: 14px; color: #555;"><strong>Note:</strong> {{ $note }}</p>
                        @endif

                        <p style="font-size: 16px; margin-top: 30px;">
                            Keep up the great work and continue referring others to earn more!
                        </p>

                        <div style="margin-top: 30px; text-align: center;">
                            <a href="{{ route('login') }}"
                               style="background-color: #0d6efd; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 5px; display: inline-block; font-weight: bold;">
                                Login to Dashboard
                            </a>
                        </div>

                        <p style="font-size: 14px; color: #999; margin-top: 40px;">If you did not expect this email, you can safely ignore it.</p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td bgcolor="#f4f4f4" style="padding: 20px; text-align: center; font-size: 12px; color: #999;">
                        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
