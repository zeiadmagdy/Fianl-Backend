<!-- resources/views/partials/sidebar.blade.php -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Users Tab -->
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Users</a>
                    <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>

                <!-- Events Tab -->
                <li class="nav-item">
                    <a href="{{ route('admin.events.index') }}" class="nav-link">

                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Events</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
