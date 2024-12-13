<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md">
        <div class="navbar-header" data-logobg="skin6">
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
            <div class="navbar-brand">
                <a href="{{ route('dashboard') }}">
                    <b class="logo-icon">
                        <img src="{{ asset('uploads/logo/small_logo.png') }}" alt="homepage" class="dark-logo" style="max-width: 45px; max-height: 45px;" />
                        <img src="{{ asset('uploads/logo/small_logo.png') }}" alt="homepage" class="light-logo" style="max-width: 45px; max-height: 45px;" />
                    </b>
                    <span class="logo-text">
                        <img src="{{ asset('uploads/logo/logo.png') }}" alt="homepage" class="dark-logo" style="max-width: 200px; max-height: 45px;" />
                        <img src="{{ asset('uploads/logo/logo.png') }}" class="light-logo" alt="homepage" style="max-width: 200px; max-height: 45px;" />
                    </span>
                </a>
            </div>
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
        </div>
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav float-left mr-auto ml-3 pl-1"></ul>
            <ul class="navbar-nav float-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        @php
                        $image = 'user-icon.jpg';
                        @endphp
                        <img src="{{ asset('uploads/users').'/'.$image }}" alt="user" class="rounded-circle" width="40">
                        <span class="ml-2 d-none d-lg-inline-block">
                            <span>Welcome, {{ auth()->user()->name }}</span>
                            <i data-feather="chevron-down" class="svg-icon"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                        <a class="dropdown-item" href="{{ route('logout') }}"><i data-feather="power" class="svg-icon mr-2 ml-1"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
