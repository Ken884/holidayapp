<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/home') }}" class="brand-link">
        <span class="brand-text font-weight-light">Portal</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar layout-fixed">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    <i class="nav-icon fas fa-user-cog fa-lg mr-2"></i>
                    {{ Auth::user()->last_name }} {{ Auth::user()->first_name }}
                </a>
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
                            <a href="{{ url('/home') }}" class="nav-link ml-1">
                                <i class="fas fa-home fa-lg"></i>
                                <p> トップ </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link ml-2">
                                <i class="fas fa-users fa-lg mr-2"></i>
                                <p>従業員一覧</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link ml-2">
                                <i class="fas fa-user-plus fa-lg mr-2"></i>
                                <p>ユーザ登録</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link ml-2">
                                <i class="fas fa-business-time fa-lg mr-2"></i>
                                <p> 勤怠管理</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link ml-2">
                                <i class="far fa-calendar-alt fa-lg mr-3"></i>
                                <p> 休暇届一覧</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link ml-2">
                                <i class="fas fa-file-invoice-dollar fa-lg mr-3"></i>
                                <p> 経費精算一覧</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link ml-2">
                                <i class="fas fa-subway fa-lg mr-3"></i>
                                <p> 通勤手当・通勤経路一覧</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>