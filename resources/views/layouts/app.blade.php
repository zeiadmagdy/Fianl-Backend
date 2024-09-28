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
])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="hold-transition">
    <div class="wrapper">
        @include('partials.header') 

        <aside class="main-sidebar sidebar-dark-primary elevation-4" >
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
])
@include('sweetalert::alert')

</body>
</html>

