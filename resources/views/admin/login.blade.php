<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
    <h1>Admin Login</h1>
    <form action="{{ route('admin.login') }}" method="POST">
        @csrf
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
