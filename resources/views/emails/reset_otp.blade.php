<!DOCTYPE html>
<html>

<head>
    <title>Password Reset OTP</title>
</head>

<body>
    <h2>Hello, there</h2>
    <p>You have requested to reset your password. Please use the following OTP to proceed:</p>

    <h3 style="text-align: center;">{{ $otp }}</h3>

    <p>The OTP is valid for 10 minutes. If you did not request a password reset, please ignore this email.</p>

    <p>Thank you,<br>
        {{ config('app.name') }}</p>
</body>

</html>
