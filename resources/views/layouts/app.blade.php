<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JMC Management System') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }

        .sidebar .nav-link {
            color: #fff;
            border-left: 3px solid transparent;
            padding-left: 1rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #495057;
            border-left-color: #0d6efd;
        }

        .sidebar .nav-link i {
            margin-right: 0.5rem;
            width: 20px;
        }

        main {
            flex: 1;
        }
    </style>
</head>

<body>
    <div id="app" class="d-flex flex-column" style="min-height: 100vh;">
        <!-- Top Navigation -->
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <i class="fas fa-building"></i> {{ config('app.name', 'JMC') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        @auth
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="">
                                        <i class="fas fa-cog"></i> Profile
                                    </a>
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <div class="d-flex flex-grow-1">
            <!-- Sidebar Navigation (for authenticated users) -->
            @auth
                <nav class="sidebar p-3" style="width: 250px; max-width: 20%;">
                    <div class="d-flex flex-column h-100">
                        <div class="nav flex-column">
                            <a class="nav-link @if (request()->routeIs('dashboard')) active @endif"
                                href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>

                            @if (Auth::user()->hasPermission('role.view'))
                                <a class="nav-link @if (request()->routeIs('roles.*')) active @endif"
                                    href="{{ route('roles.index') }}">
                                    <i class="fas fa-shield-alt"></i> Kelola Role
                                </a>
                            @endif

                            @if (Auth::user()->hasPermission('user.view'))
                                <a class="nav-link @if (request()->routeIs('users.*')) active @endif"
                                    href="{{ route('users.index') }}">
                                    <i class="fas fa-users"></i> Kelola User
                                </a>
                            @endif

                            @if (Auth::user()->hasPermission('employee.view'))
                                <a class="nav-link @if (request()->routeIs('employees.*')) active @endif"
                                    href="{{ route('employees.index') }}">
                                    <i class="fas fa-id-card"></i> Data Pegawai
                                </a>
                            @endif

                            @if (Auth::user()->hasPermission('transport-allowance.view'))
                                <a class="nav-link @if (request()->routeIs('transport-allowances.*')) active @endif"
                                    href="{{ route('transport-allowances.index') }}">
                                    <i class="fas fa-money-bill-wave"></i> Tunjangan Transport
                                </a>
                            @endif

                            @if (Auth::user()->hasPermission('transport-settings.view'))
                                <a class="nav-link @if (request()->routeIs('transport-settings.*')) active @endif"
                                    href="{{ route('transport-settings.index') }}">
                                    <i class="fas fa-cogs"></i> Setting Tunjangan
                                </a>
                            @endif

                            @if (Auth::user()->hasPermission('activity-log.view'))
                                <a class="nav-link @if (request()->routeIs('activity-logs.*')) active @endif"
                                    href="{{ route('activity-logs.index') }}">
                                    <i class="fas fa-history"></i> Log Aktivitas
                                </a>
                            @endif

                            <hr class="my-2">

                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                            <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </nav>
            @endauth

            <!-- Main Content -->
            <main class="flex-grow-1">
                <div class="container-fluid py-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
