<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Email Reset Confirmation</title>
</head>
<body>
    <h2>Hello {{ $user->name }}</h2>

    <p>You are receiving this email because we received a request to change the email associated with your account.</p>
    <p><a href="{{ $confirmationUrl }}"
            style="background-color: #0097eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Confirm
            Email Change</a></p>


    <p>If you did not request this change, please ignore this email.</p>

    <br>
    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>

</html>
