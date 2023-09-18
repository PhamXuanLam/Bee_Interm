<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('/vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">User</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('/vendor/adminlte/dist/img/avatar.png') }} " class="img-circle elevation-2" alt="User Image">
            </div>
            @if(\Illuminate\Support\Facades\Auth::check())
                <div class="info">
                    <a href="#" class="d-block">{{auth()->guard()->user()->user_name}}</a>
                </div>
            @else
                <div class="info">
                    <a href="/login" class="d-block">Login</a>
                </div>
            @endif

        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-house"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Active Page</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Inactive Page</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route("category.index") }}"
                       class="nav-link {{request()->routeIs('category.*') ? 'active': ''}}">
                        <i class="nav-icon fa-regular fa-user"></i>
                        <p>
                            {{__("Categories")}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route("order.index") }}"
                       class="nav-link {{request()->routeIs('order.*') ? 'active': ''}}">
                        <i class="nav-icon fa-regular fa-user"></i>
                        <p>
                            {{__("Orders")}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('product.index')}}"
                       class="nav-link {{request()->routeIs('product.*') ? 'active': ''}}">
                        <i class="nav-icon fa-regular fa-user"></i>
                        <p>
                            {{__("Sidebar Product")}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('statistical.index')}}"
                       class="nav-link {{request()->routeIs('statistical.*') ? 'active': ''}}">
                        <i class="nav-icon fa-regular fa-user"></i>
                        <p>
                            {{__("Statistical")}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a href="#" class="nav-link" onclick="document.getElementById('logoutForm').submit();">
                            <i class="nav-icon fa-solid fa-right-from-bracket"></i>
                            <p>Log out</p>
                        </a>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
