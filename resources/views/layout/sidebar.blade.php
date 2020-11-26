<!-- Main Sidebar Container -->
@if(auth('root')->check())
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="dist/img/AdminLTELogo.png"
             alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="pull-left image">
                <img src="http://www.clker.com/cliparts/d/L/P/X/z/i/no-image-icon-hi.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p style="margin-bottom: 4px; color: #ffffff">{{auth('root')->user()->email}}</p>
                <a href="{{$_SERVER['REQUEST_URI']}}"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item header" style="color: #ffffff">LAYOUT ADMIN</li>
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item @yield('active-link-employees')">
                    <a class="nav-link" href="{{route('employees.index')}}">
                        <i class="fa fa-th"></i> <span>Quản lý nhân viên</span>
                        <span class="pull-right-container">
              <!--<small class="label pull-right bg-green">new</small>-->
                        </span>
                    </a>
                </li>
                <li class="nav-item @yield('active-link-departments')">
                    <a class="nav-link" href="{{route('departments.index')}}">
                        <i class="fa fa-code"></i> <span>Quản lý phòng ban</span>
                        <span class="pull-right-container">
              <!--<small class="label pull-right bg-green">new</small>-->
                        </span>
                    </a>
                </li>
                <li class="nav-item @yield('active-link-requests')">
                    <a class="nav-link" href="{{route('requests.index')}}">
                        <i class="fas fa-images" style="width: 20px" aria-hidden="true"></i> <span>Yêu cầu cần duyệt</span>
                        <span class="pull-right-container"></span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
@else
<aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="" class="brand-link">
            <img src="dist/img/AdminLTELogo.png"
                 alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="pull-left image">
                    <img src="http://www.clker.com/cliparts/d/L/P/X/z/i/no-image-icon-hi.png" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p style="margin-bottom: 4px; color: #ffffff">{{auth('employees')->user()->first_name}} {{auth('employees')->user()->last_name}}</p>
                    <p style="margin-bottom: 4px; color: #ffffff">{{auth('employees')->user()->email}}</p>
                    <a href="{{$_SERVER['REQUEST_URI']}}"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item header" style="color: #ffffff">LAYOUT ADMIN</li>
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item @yield('active-link-calendar')">
                        <a class="nav-link" href="">
                            <i class="fa fa-th"></i> <span>Lịch làm việc</span>
                            <span class="pull-right-container">
              <!--<small class="label pull-right bg-green">new</small>-->
                        </span>
                        </a>
                    </li>
                    @if(auth('employees')->user()->user_type == 1)
                        <li class="nav-item @yield('active-link-list-employees')">
                            <a class="nav-link" href="{{route('list-employees')}}">
                                <i class="fa fa-th"></i> <span>Quản lý nhân viên</span>
                                <span class="pull-right-container">
              <!--<small class="label pull-right bg-green">new</small>-->
                        </span>
                            </a>
                        </li>
                        <li class="nav-item @yield('active-link-working-schedule')">
                            <a class="nav-link" href="{{route('working-schedule')}}">
                                <i class="fa fa-th"></i> <span>Quản lý lịch làm việc của nhân viên</span>
                                <span class="pull-right-container">
              <!--<small class="label pull-right bg-green">new</small>-->
                        </span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item @yield('active-link-requests')">
                        <a class="nav-link" href="employee/requests">
                            <i class="fa fa-code"></i> <span>Danh sách yêu cầu</span>
                            <span class="pull-right-container">
              <!--<small class="label pull-right bg-green">new</small>-->
                        </span>
                        </a>
                    </li>
                    <li class="nav-item @yield('active-link-requests-approval')">
                        <a class="nav-link" href="employee/requests-approval">
                            <i class="fas fa-images" style="width: 20px" aria-hidden="true"></i> <span>Yêu cầu cần duyệt</span>
                            <span class="pull-right-container"></span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
@endif
