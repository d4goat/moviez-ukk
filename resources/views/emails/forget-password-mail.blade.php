<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password OTP</title>
</head>
<body style="color: #f4f4f4; text-align: center; background-color: #0f1014; font-family: 'Poppins', sans-serif; padding: 2rem 1rem;">
    <div style="max-width: 480px; margin: 0 auto; color: #ddd;">
        <h1 style="color: #f4f4f4;">Matix Cineplex - Movie Ticket Booking</h1>
        <div style="border: 2px solid #26272e; color: #f4f4f4; padding: 2rem 1.5rem; border-radius: 0.5rem;">
            <div>
                <h2 style="font-weight: 500; color: #f4f4f4;">Reset your account password</h2>
                <p style="font-size: 1rem; color: #f4f4f4;">We heard that you lost your Matix password. Sorry about that!</p>
                <p style="font-size: 1rem; color: #f4f4f4;">But don't worry! You can use the OTP code below to reset your password:</p>
                <div style="margin: 1.5rem 0; padding: 1rem; background-color: #229ae0; border-radius: 0.5rem; display: inline-block; text-align: center;">
                    <h2 style="margin: 0; font-size: 2rem; letter-spacing: 5px; color: white;">{{ $otp }}</h2>
                </div>
                <p style="color: #f4f4f4;">
                    This OTP code will expire in <strong>2 minutes</strong>.
                </p>
                <p style="color: #f4f4f4;">
                    <small>If you did not register at Matix Cineplex, please ignore this email.</small>
                </p>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <div>
                <small style="color: #f4f4f4">{{ date('Y') }} ©</small>
                <small style="color: #f4f4f4;">Matix Cineplex - Movie Ticket Booking</small>
            </div>
        </div>
    </div>
</body>
</html>
