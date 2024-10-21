<ul class="nav nav-pills nav-sidebar flex-column w-100" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link " href="{{ route('admin.dashboard') }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
        </a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link " href="{{ route('admin.insights') }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Insights</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.users.index') }}" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Users</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.calendar.index') }}" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Calendar</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.events.index') }}" class="nav-link">
            <i class="nav-icon fas fa-calendar"></i>
            <p>Events</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.categories.index') }}" class="nav-link">
            <i class="nav-icon fas fa-list"></i>
            <p>Categories</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.buses.index') }}" class="nav-link">
            <i class="nav-icon fas fa-bus"></i> <!-- Using a bus icon for buses -->
            <p>Buses</p>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.drivers.index') }}"  class="nav-link">
            <i class="nav-icon fas fa-user-tie"></i> Drivers
        </a>
    </li>

    <!-- New Image Creation Section -->
    <li class="nav-item">
        <a href="{{ route('admin.image_creation.index') }}" class="nav-link"> <!-- Updated link -->
            <i class="nav-icon fas fa-image"></i> <!-- Icon for Image Creation -->
            <p>Image Creation</p>
        </a>
    </li>


    <li class="nav-item">
        <a href="{{ route('admin.contacts') }}" class="nav-link">
            <i class="nav-icon fas fa-address-book"></i>
            <p>Contacts</p>
        </a>
    </li>
    
</ul>