<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <!-- Load assets via Vite -->
    @vite([
        'resources/js/app.js',
        'resources/css/app.css',
        'node_modules/admin-lte/dist/css/adminlte.min.css',
        'node_modules/admin-lte/plugins/fontawesome-free/css/all.min.css',
        'node_modules/admin-lte/plugins/bootstrap/css/bootstrap.min.css',
        'node_modules/@fullcalendar/core/main.min.css',
        'node_modules/@fullcalendar/daygrid/main.min.css'
    ])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="hold-transition">
    <div class="wrapper">
        @include('partials.header') 

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            @include('partials.sidebar')
        </aside>

        <div class="content-wrapper p-4">
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        @include('partials.footer')
    </div>

    <!-- Vite will load JS dependencies -->
    @vite([
        'node_modules/admin-lte/plugins/jquery/jquery.min.js',
        'node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js',
        'node_modules/admin-lte/dist/js/adminlte.min.js',
        'node_modules/@fullcalendar/core/main.min.js',
        'node_modules/@fullcalendar/daygrid/main.min.js',
        'node_modules/@fullcalendar/interaction/main.min.js'
    ])
    
    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="path/to/your/app.js"></script>
</body>
</html>
