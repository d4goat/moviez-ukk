<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password OTP</title>
</head>
<body style="color: #252a61; text-align: center; background-color: #f4f4f4; font-family: 'Poppins', sans-serif; padding: 2rem 1rem;">
    <div style="max-width: 480px; margin: 0 auto; background-color: #ffffff; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <h1 style="color: #252a61;">Forgot Password Request</h1>
        <p style="font-size: 1rem; color: #555;">Hello <strong>{{ $name }}</strong>,</p>
        <p style="font-size: 1rem; color: #555;">We received a request to reset your password. Use the OTP code below to proceed:</p>
        <div style="margin: 1.5rem 0; padding: 1rem; background-color: #e0f7fa; border-radius: 0.5rem; display: inline-block; text-align: center;">
            <h2 style="margin: 0; font-size: 2rem; letter-spacing: 5px; color: #252a61;">{{ $otp }}</h2>
        </div>
        <p style="font-size: 1rem; color: #555;">This OTP is valid for <strong>2 minutes</strong>.</p>
        <p style="font-size: 0.9rem; color: #888; margin-top: 2rem;">If you did not request a password reset, please ignore this email or contact our support team.</p>
        <hr style="border: none; border-top: 1px solid #ddd; margin: 2rem 0;">
        <p style="font-size: 0.8rem; color: #aaa;">© {{ date('Y') }} Matix Cineplex. All rights reserved.</p>
    </div>
</body>
</html>
