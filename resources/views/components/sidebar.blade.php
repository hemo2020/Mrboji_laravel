<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('assets/images/logo-icon.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>
    @php $route = \Request::route()->getName(); use \Illuminate\Support\Facades\Auth; use App\Models\User;@endphp
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- SidebarSearch Form -->
        <div class="form-inline d-none">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
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
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ $route == 'admin.dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard <span class="right badge badge-danger d-none">New</span></p>
                    </a>
                </li>

                @if(in_array(Auth::user()->role, [User::ADMIN, User::WRITER]))
                    <li class="nav-item">
                        <a href="{{ route('admin.brands') }}"
                           class="nav-link {{ $route == 'admin.brands' ? 'active' : '' }}">
                            <i class="nav-icon fa fa-shopping-cart"></i>
                            <p>Brands</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.models') }}"
                           class="nav-link {{ $route == 'admin.models' ? 'active' : '' }}">
                            <i class="nav-icon fa fa-shopping-cart"></i>
                            <p>Models</p>
                        </a>
                    </li>
                    @if(Auth::user()->role == User::ADMIN)
                        <li class="nav-item">
                            <a href="{{ route('admin.cars') }}"
                                class="nav-link {{ $route == 'admin.cars' ? 'active' : '' }}">
                                <i class="nav-icon fa fa-shopping-cart"></i>
                                <p>Cars</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users') }}"
                                class="nav-link {{ $route == 'admin.users' ? 'active' : '' }}">
                                <i class="nav-icon fa fa-user"></i>
                                <p>Users</p>
                            </a>
                        </li>
                    @endif
                @endif
                <li class="nav-item {{ ($route == 'admin.cases') ? 'menu-open' : '' }}">
                    <a href="{{route('admin.cases')}}" class="nav-link {{ (($route == 'admin.cases') && app('request')->input('status')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-phone-volume"></i>
                        <p>Cases <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.cases')}}" class="nav-link {{ ($route == 'admin.cases') && !app('request')->input('status') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-phone-volume"></i>
                                <p>All</p>
                            </a>
                        </li>
                        @foreach(\App\Models\Cases::STATUSES as $key => $status)
                            <li class="nav-item">
                                <a href="{{route('admin.cases')}}?status={{$status}}" class="nav-link {{ ( app('request')->input('status') == $status) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-phone-volume"></i>
                                    <p>{{$status}}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
