<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/home') }}" class="brand-link">
        <span class="brand-text font-weight-light">Portal</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->last_name }} {{ Auth::user()->first_name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p> MENU </p>
                        <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/home') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> トップ </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview menu-open">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> 休暇届 <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('holiday_home')}}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p> 一覧 </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('holiday_create')}}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p> 申請 </p>
                                    </a>
                                </li>
                                @can('admin')
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p> 承認 </p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p> 経費精算 <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('expense_home') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p> 一覧 </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('expense_create') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p> 申請 </p>
                                    </a>
                                </li>
                                @can('admin')
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p> 承認 </p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>