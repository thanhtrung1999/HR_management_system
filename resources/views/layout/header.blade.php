<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            @yield('breadcrumb')
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{empty(auth('employees')->user()->avatar) ? 'http://www.clker.com/cliparts/d/L/P/X/z/i/no-image-icon-hi.png' : 'images/uploads/'.auth('employees')->user()->avatar}}" class="user-image" alt="User Image">
                <span class="hidden-xs"></span>
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    <img src="{{empty(auth('employees')->user()->avatar) ? 'http://www.clker.com/cliparts/d/L/P/X/z/i/no-image-icon-hi.png' : 'images/uploads/'.auth('employees')->user()->avatar}}" class="img-circle" alt="User Image">

                    @if(auth('root')->check())
                        <p>{{auth('root')->user()->email}}</p>
                    @else
                        <p class="m-0">{{auth('employees')->user()->first_name}} {{auth('employees')->user()->last_name}}</p>
                        <p class="m-0" style="font-size: 1rem">
                            <span>Làm việc tại: {{auth('employees')->user()->employeeOfDepartment->name}}</span>
                            @if(auth('employees')->user()->user_type == 0 && !empty(auth('employees')->user()->employeeOfDepartment->manager))
                                <br>
                                <span>Trưởng phòng quản lý: {{auth('employees')->user()->employeeOfDepartment->manager->first_name}} {{auth('employees')->user()->employeeOfDepartment->manager->last_name}}</span>
                            @endif
                        </p>
                    @endif
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="pull-left">
                        <a href="{{route('profile.index')}}" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                        <a href="logout" class="btn btn-default btn-flat">Sign
                            out</a>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
