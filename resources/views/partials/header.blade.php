<!-- resources/views/partials/header.blade.php -->
<nav class="main-header navbar navbar-expand navbar-black navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Center title with logo -->
    <div class="navbar-brand mx-auto">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 90px; margin-top: -5px;">
        <span class="navbar-title">Admin Panel</span>
    </div>

    <!-- No right navbar links -->
</nav>

<!-- Add some custom CSS for better styling -->
<style>
    .navbar {
        background-color: black; /* Flat black background */
    }

    .navbar-title {
        font-size: 24px; /* Adjust font size as needed */
        font-weight: bold; /* Make title bold */
        color: white; /* Flat white color for title */
        vertical-align: middle; /* Aligns the title vertically with the logo */
    }

    .navbar img {
        vertical-align: middle; /* Aligns the logo vertically */
    }
</style>
