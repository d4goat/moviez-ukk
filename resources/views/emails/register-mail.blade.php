<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OTP Verification</title>
</head>
<body style="color: #f4f4f4; text-align: center; background-color: 14171c; font-family: 'Poppins', sans-serif; padding: 2rem 1rem;">
    <div style="max-width: 480px; margin: 0 auto">
        <h1>Matix Cineplex - Movie Ticket Booking</h1>
        <div style="border-top: 8px solid #252a61; background-color: #fff; padding: 2rem 1.5rem; border-radius: 0.5rem;">
            <div>
                <h2 style="font-weight: 500">Welcome to Matix Cineplex, {{ $name }}!</h2>
                <p>To confirm it's you who registered, here is the <strong>OTP Code</strong> for your registration verification:</p>
                <div style="padding: 0.75rem 1.5rem; background-color: lightcyan; border-radius: 0.5rem; display: inline-block; margin: 1.25rem 0; overflow: hidden;">
                    <h1 style="letter-spacing: 5px; margin: 0">{{ $otp }}</h1>
                </div>
                <p>
                    This OTP code will expire in <strong>2 minutes</strong>.
                </p>
                <p>
                    <small>If you did not register at Matix Cineplex, please ignore this email.</small>
                </p>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <div>
                <small>{{ date('Y') }} ©</small>
                <small>Matix Cineplex - Movie Ticket Booking</small>
            </div>
        </div>
    </div>
</body>
</html>