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
        @if(Auth::check())
        <div class="user-panel mt-3 pb-3 mb-3">
            <div class=" d-flex">
                <div class="image">
                    <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="{{ route('home') }}" class="d-block">{{Auth::user()->name}}</a>
                </div>
            </div>
        </div>
        @endif
        <!-- Sidebar Menu -->
        <nav class="mt-2 mb-4">
            @if(Auth::check())
            <ul class="nav nav-pills user-panel nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>
                            User
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if(Auth::user()->role == 1)
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
                        @else
                        <form action="{{asset('users/detail')}}" method="post"  id="detailForm">
                            <input type="hidden" name="id">
                            @csrf
                        </form>
                        <li class="nav-item">
                            <a href="javascript:void(0)" user-id="{{Auth::user()->id}}" class="nav-link updateUser">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Update</p>
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('user_password') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                    </ul>
                </li>
                 @if(Auth::user()->role == 1)
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
                        <i class="nav-icon fas fa-money-bill-alt"></i>
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
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Company
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('companySearch')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Search</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('companyRegist')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Regist</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-people-arrows"></i>
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
                    <a href="{{route('calcSalary')}}" class="nav-link">
                        <i class="nav-icon fas fa-hand-holding-usd"></i>
                        <p>
                            Salary Cal
                        </p>
                    </a>
                </li>
                @endif
                <li class="nav-item has-treeview">
                    <a href="{{route('worktime')}}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Work time
                        </p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-pills user-panel nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
            @endif
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
@section('js')
    <script>
        $(document).ready(function() {
            $('.updateUser').click(function(){
                $('#detailForm').find('input[name="id"]').val($(this).attr('user-id'));
                $('#detailForm').submit();
            });
        });
    </script>
@endsection
