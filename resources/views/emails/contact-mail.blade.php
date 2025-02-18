<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Us - Matix Cineplex</title>
</head>
<body style="color: #f4f4f4; text-align: center; background-color: #0f1014; font-family: 'Poppins', sans-serif; padding: 2rem 1rem;">
    <div style="max-width: 480px; margin: 0 auto; color: #ddd;">
        <h1 style="">Matix Cineplex - Movie Ticket Booking</h1>
        <div style="border: 2px solid #26272e; padding: 2rem 1.5rem; border-radius: 0.5rem;">
            <div>
                <h2 style="font-weight: 500; ">New Contact Us Message</h2>
                <p style="font-size: 1rem; ">You have received a new message from a user:</p>

                <div style="text-align: left; margin: 1.5rem 0;">
                    <p><strong>Name:</strong> {{ $name }}</p>
                    <p><strong>Email:</strong> {{ $email }}</p>
                    <p><strong>Type:</strong> {{ $type }}</p>
                    <p><strong>Subject:</strong> {{ $subjectContent }}</p>
                    <p><strong>Message:</strong></p>
                    <p style="background-color: #26272e; padding: 1rem; border-radius: 0.5rem;">{{ $messageContent }}</p>
                </div>

                <p>
                    <small>This message was sent via the Contact Us form on Matix Cineplex.</small>
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
