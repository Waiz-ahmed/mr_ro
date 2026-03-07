<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'POS System')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css" />
    @stack('styles')

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1 0 auto;
        }

        footer {
            flex-shrink: 0;
        }

        .nav-link {
            color: #fff !important;
            font-weight: 400 !important;
        }

        .navbar-brand {
            font-weight: bold !important;
        }
    </style>
</head>

<body>

    {{-- Navbar for authenticated users --}}
    @auth
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <!-- <img src="{{ asset('images/mr_ro_logo.jpg') }}" alt="Logo" style="height: 50px; width: auto; vertical-align: middle;"> -->
                <span style="margin-left: 8px;">POS System</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    {{-- Menu items based on permissions --}}
                    
                    {{-- Customers - Visible to admin, staff, or users with permission --}}
                    @permission('view-customers')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customers.index') }}">
                            <i class="fa fa-users"></i> Customers
                        </a>
                    </li>
                    @endpermission

                    {{-- Credit Customers - Visible to admin, staff, or users with permission --}}
                    @permission('view-credits')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('credits.index') }}">
                            <i class="fa fa-credit-card"></i> Credit Customers
                        </a>
                    </li>
                    @endpermission

                    {{-- Payments - Visible to admin, staff, or users with permission --}}
                    @permission('view-payments')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('payments.index') }}">
                            <i class="fa fa-money-bill"></i> Payments
                        </a>
                    </li>
                    @endpermission

                    {{-- Shops - Visible to admin, staff, or users with permission --}}
                    @permission('view-shops')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shops.cards') }}">
                            <i class="fa fa-store"></i> Shops
                        </a>
                    </li>
                    @endpermission

                    {{-- All Orders - Visible to admin, staff, or users with permission --}}
                    @permission('view-orders')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sales.index') }}">
                            <i class="fa fa-shopping-cart"></i> All Orders
                        </a>
                    </li>
                    @endpermission

                    {{-- Vendors - Visible only to admin or users with permission --}}
                    @permission('view-vendors')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vendors.index') }}">
                            <i class="fa fa-truck"></i> Vendors
                        </a>
                    </li>
                    @endpermission

                    {{-- Expenses - Visible only to admin or users with permission --}}
                    @permission('view-expenses')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('expenses.index') }}">
                            <i class="fa fa-chart-line"></i> Expenses
                        </a>
                    </li>
                    @endpermission

                    {{-- Reports Dropdown - Visible to admin or users with view-reports permission --}}
                    @permission('view-reports')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fa fa-chart-bar"></i> Reports
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('sales.report', ['type' => 'daily']) }}">Daily Sales</a></li>
                            <li><a class="dropdown-item" href="{{ route('sales.report', ['type' => 'credit']) }}">Credit Sales Only</a></li>
                            <li><a class="dropdown-item" href="{{ route('sales.report', ['type' => 'non-credit']) }}">Non-Credit Sales</a></li>
                        </ul>
                    </li>
                    @endpermission

                    {{-- Settings Dropdown - Visible to users with any settings permission --}}
                    @anypermission('view-settings|manage-settings|manage-permissions|manage-shops')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="settingsDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fa fa-cog"></i> Settings
                        </a>
                        <ul class="dropdown-menu">
                            {{-- My Shops - Visible to users with manage-shops permission --}}
                            @permission('manage-shops')
                            <li>
                                <a class="dropdown-item" href="{{ route('shops.settings') }}">
                                    <i class="fa fa-store"></i> Shops
                                </a>
                            </li>
                            @endpermission

                            {{-- Taxes - Placeholder for future --}}
                            @permission('manage-taxes')
                            <li><a class="dropdown-item" href="#"><i class="fa fa-percent"></i> Taxes</a></li>
                            @endpermission

                            {{-- Printers - Placeholder for future --}}
                            @permission('manage-printers')
                            <li><a class="dropdown-item" href="#"><i class="fa fa-print"></i> Printers</a></li>
                            @endpermission

                            {{-- Permissions - Visible to users with manage-permissions permission --}}
                            @permission('manage-permissions')
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.permissions.index') }}">
                                    <i class="fa fa-shield-alt"></i> Permissions
                                </a>
                            </li>
                            @endpermission

                            {{-- General Settings - Visible to users with manage-settings permission --}}
                            @permission('manage-settings')
                            <li>
                                <a class="dropdown-item" href="{{ route('settings.general') }}">
                                    <i class="fa fa-sliders-h"></i> General Settings
                                </a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endanypermission

                    {{-- Fallback for admin/staff using old role system (temporary) --}}
                    @if (in_array(Auth::user()->role, ['admin', 'staff']) && !auth()->user()->hasPermission('view-customers'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customers.index') }}">Customers (Legacy)</a>
                    </li>
                    @endif
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user-circle fa-lg me-2"></i>
                            {{ Auth::user()->name }}
                            @role('admin')
                                <span class="badge bg-warning text-dark ms-2">Admin</span>
                            @else
                                <span class="badge bg-info ms-2">{{ Auth::user()->role }}</span>
                            @endrole
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fa fa-user"></i> Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">
                                        <i class="fa fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endauth

    {{-- Page content --}}
    <div class="main-content container-fluid py-4">
        {{-- Session flash messages --}}
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Blade section content --}}
        @yield('content')
    </div>

    <footer class="text-center text-muted py-2 bg-light border-top">
        &copy; {{ date('Y') }} POS System | Powered by 
        <a href="https://codecousins.com/" target="_blank" class="text-decoration-none">
            CodeCousins
        </a>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @stack('scripts')
</body>

</html>