<!-- Brand Logo -->
<a href="#" class="brand-link">
    <img src="{{ asset('img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
        class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">{{ auth()->user()->name }}</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="{{route('home')}}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Projects</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('all-tasks-list')}}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>All Tasks</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->


