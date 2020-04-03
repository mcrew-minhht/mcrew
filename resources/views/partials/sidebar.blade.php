<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">MCREW TECH</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3">
            <div class=" d-flex">
                <div class="image">
                    <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="{{ route('home') }}" class="d-block">MinhHT</a>
                </div>
            </div>
            <div class="pl-13">
                <a href="logout">Logout</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            User
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user_search') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Search</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user_regist') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Regist</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Project
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('searchProject')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Search</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('registProject')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Regist</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>
                            Salary
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('searchSalary')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Search</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('registSalary')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Regist</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Company
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="companies" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Search</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="companies/regist" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Regist</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Customers
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('customerSearch')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Search</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('customerRegist')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Regist</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('worktime')}}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Work time
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('calcSalary')}}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Salary Cal
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
