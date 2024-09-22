<ul class="nav nav-pills nav-sidebar flex-column w-100" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link " href="{{ route('admin.dashboard') }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.users.index') }}" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Users</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.events.index') }}" class="nav-link">
            <i class="nav-icon fas fa-calendar"></i>
            <p>Events</p>
        </a>
    </li>
</ul>