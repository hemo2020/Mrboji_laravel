<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    @php $user = \Auth::user();@endphp
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown d-none" id="top-notification">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                @php $logoUrl = asset('assets/images/logo-icon.png'); @endphp
                <img src="{{ $logoUrl }}" class="user-image" alt="User Image">
                <span class="hidden-xs">{{ $user->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right user-menu">
                <ul class="">
                    <!-- User image -->
                    <li class="user-header">
                        <!-- <img src="{{ $logoUrl }}" class="img-circle" alt="User Image" style="width: 50px;"> -->
                        <p>{{ $user->name}}</p>
                    </li>
                    <div class="dropdown-divider"></div>
                    <li class="user-footer">
                        <div class="">
                            <a href="{{ route('admin.profile.edit') }}" class="btn btn-default btn-flat btn-block">My Profile</a>
                            <a class="btn btn-default btn-flat btn-block" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
