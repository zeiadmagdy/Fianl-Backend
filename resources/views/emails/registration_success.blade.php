<!DOCTYPE html>
<html>

<head>
    <title>Registration Successful</title>
</head>

<body>
    <h2>Welcome, {{ $user->name }}!</h2>
    <p>Thank you for registering with us. Your account has been created successfully.</p>
    <p>You can now log in and start using our services.</p>
    <p>Best Regards,<br>{{ config('app.name') }}</p>
</body>

</html>