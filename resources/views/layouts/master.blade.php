<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'POS System')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css" />
    @stack('styles')

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        /* ── Layout shell ── */
        .app-shell {
            display: flex;
            height: 100vh;
        }

        /* ── Sidebar ── */
        #sidebar {
            width: 240px;
            min-width: 240px;
            background: #0d6efd;
            display: flex;
            flex-direction: column;
            transition: width 0.25s ease, min-width 0.25s ease;
            z-index: 1040;
            flex-shrink: 0;
        }

        #sidebar.collapsed {
            width: 56px;
            min-width: 56px;
        }

        /* Sidebar header */
        .sb-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            white-space: nowrap;
            flex-shrink: 0;
            overflow: hidden;
        }

        .sb-brand {
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            opacity: 1;
            transition: opacity 0.2s;
            overflow: hidden;
        }

        #sidebar.collapsed .sb-brand {
            opacity: 0;
            pointer-events: none;
        }

        /* Toggle button */
        #sb-toggle {
            background: none;
            border: none;
            cursor: pointer;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #fff;
            font-size: 18px;
            transition: background 0.15s;
        }

        #sb-toggle:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        #sb-toggle i {
            transition: transform 0.25s;
        }

        #sidebar.collapsed #sb-toggle i {
            transform: rotate(180deg);
        }

        /* Nav scroll area */
        .sb-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 8px 0;
        }

        .sb-nav::-webkit-scrollbar {
            display: none;
        }

        .sb-nav {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        /* Section headers */
        .sb-section {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.45);
            padding: 14px 16px 4px;
            white-space: nowrap;
            transition: opacity 0.2s;
        }

        #sidebar.collapsed .sb-section {
            opacity: 0;
            display: none !important;
        }

        /* Nav items */
        .sb-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            color: rgba(255, 255, 255, 0.85);
            font-size: 13.5px;
            text-decoration: none;
            white-space: nowrap;
            transition: background 0.15s, color 0.15s;
            position: relative;
        }

        .sb-item:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            text-decoration: none;
        }

        .sb-item.active {
            background: rgba(255, 255, 255, 0.18);
            color: #fff;
        }

        .sb-item i {
            font-size: 15px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .sb-label {
            opacity: 1;
            transition: opacity 0.2s;
            overflow: hidden;
        }

        #sidebar.collapsed .sb-label {
            opacity: 0;
        }

        /* User dropdown — always pops right so it's never clipped by sidebar */
        .sb-footer .dropdown-menu {
            position: fixed !important;
            bottom: 60px;
            left: auto;
            top: auto;
            min-width: 180px;
            z-index: 2000;
        }

        .sb-footer .dropdown-menu.show {
            display: block;
        }
        #sidebar.collapsed .sb-item::after {
            content: attr(data-label);
            position: absolute;
            left: 56px;
            background: #1a1a2e;
            color: #fff;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 6px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s;
            z-index: 2000;
        }

        #sidebar.collapsed .sb-item:hover::after {
            opacity: 1;
        }

        /* Dropdown caret */
        .sb-caret {
            margin-left: auto;
            font-size: 11px;
            opacity: 0.6;
            transition: transform 0.2s, opacity 0.2s;
        }

        #sidebar.collapsed .sb-caret {
            opacity: 0;
        }

        .sb-item[aria-expanded="true"] .sb-caret {
            transform: rotate(90deg);
        }

        /* Sub-menu */
        .sb-submenu {
            background: rgba(0, 0, 0, 0.12);
            overflow: hidden;
        }

        .sb-submenu .sb-item {
            padding-left: 44px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.75);
        }

        #sidebar.collapsed .sb-submenu {
            display: none;
        }

        /* User footer */
        .sb-footer {
            padding: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            flex-shrink: 0;
            position: relative;
        }

        .sb-user {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            border-radius: 8px;
            padding: 4px 6px;
            transition: background 0.15s;
            text-decoration: none;
            white-space: nowrap;
        }

        .sb-user:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sb-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            color: #fff;
            flex-shrink: 0;
        }

        .sb-user-info {
            opacity: 1;
            transition: opacity 0.2s;
            overflow: hidden;
        }

        #sidebar.collapsed .sb-user-info {
            opacity: 0;
        }

        .sb-user-name {
            font-size: 13px;
            font-weight: 500;
            color: #fff;
            line-height: 1.2;
        }

        .sb-user-role {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.55);
        }

        /* ── Main area ── */
        .app-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-width: 0;
        }

        /* Top bar */
        .app-topbar {
            height: 54px;
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            padding: 0 20px;
            gap: 12px;
            flex-shrink: 0;
        }

        .app-topbar .page-title {
            font-size: 15px;
            font-weight: 600;
            color: #212529;
            margin: 0;
        }

        /* Page content */
        .app-content {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
        }

        /* Flash messages */
        .flash-stack {
            margin-bottom: 20px;
        }

        /* Mobile overlay */
        #sb-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 1039;
        }

        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                transform: translateX(-100%);
                width: 240px !important;
                min-width: 240px !important;
                transition: transform 0.25s ease;
            }

            #sidebar.mobile-open {
                transform: translateX(0);
            }

            #sidebar.collapsed {
                transform: translateX(-100%);
            }

            #sb-overlay.active {
                display: block;
            }

            /* Show the mobile toggle in topbar */
            #mobile-toggle {
                display: flex !important;
            }
        }

        #mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: #495057;
            cursor: pointer;
            padding: 4px 8px;
        }
    </style>
</head>

<body>
<div class="app-shell">

    {{-- ── Sidebar ── --}}
    @auth
    <nav id="sidebar">

        {{-- Header --}}
        <div class="sb-header">
            <button id="sb-toggle" onclick="toggleSidebar()" title="Toggle sidebar">
                <i class="fa fa-chevron-left"></i>
            </button>
            <span class="sb-brand">POS System</span>
        </div>

        {{-- Nav items --}}
        <div class="sb-nav">

            {{-- Main --}}
            <div class="sb-section">Main</div>

            @if(auth()->user()->hasRole('super-admin'))
            <a class="sb-item {{ request()->is('dashboard') ? 'active' : '' }}"
            href="{{ route('dashboard') }}" data-label="Dashboard">
                <i class="fa fa-th-large"></i>
                <span class="sb-label">Dashboard</span>
            </a>
            @else
            <a class="sb-item {{ request()->is('my-dashboard') ? 'active' : '' }}"
            href="{{ route('user.dashboard') }}" data-label="Dashboard">
                <i class="fa fa-th-large"></i>
                <span class="sb-label">Dashboard</span>
            </a>
            @endif

            @permission('view-customers')
            <a class="sb-item {{ request()->routeIs('customers.*') ? 'active' : '' }}"
               href="{{ route('customers.index') }}"
               data-label="Customers">
                <i class="fa fa-users"></i>
                <span class="sb-label">Customers</span>
            </a>
            @endpermission

            @permission('view-credits')
            <a class="sb-item {{ request()->routeIs('credits.*') ? 'active' : '' }}"
               href="{{ route('credits.index') }}"
               data-label="Credit Customers">
                <i class="fa fa-credit-card"></i>
                <span class="sb-label">Credit Customers</span>
            </a>
            @endpermission

            @permission('view-payments')
            <a class="sb-item {{ request()->routeIs('payments.*') ? 'active' : '' }}"
               href="{{ route('payments.index') }}"
               data-label="Payments">
                <i class="fa fa-money-bill"></i>
                <span class="sb-label">Payments</span>
            </a>
            @endpermission

            @permission('view-orders')
            <a class="sb-item {{ request()->routeIs('sales.*') ? 'active' : '' }}"
               href="{{ route('sales.index') }}"
               data-label="All Orders">
                <i class="fa fa-shopping-cart"></i>
                <span class="sb-label">All Orders</span>
            </a>
            @endpermission

            @permission('view-shops')
            <a class="sb-item {{ request()->routeIs('shops.*') ? 'active' : '' }}"
               href="{{ route('shops.cards') }}"
               data-label="Shops">
                <i class="fa fa-store"></i>
                <span class="sb-label">Shops</span>
            </a>
            @endpermission

            {{-- Operations --}}
            <div class="sb-section">Operations</div>

            @permission('view-vendors')
            <a class="sb-item {{ request()->routeIs('vendors.*') ? 'active' : '' }}"
               href="{{ route('vendors.index') }}"
               data-label="Vendors">
                <i class="fa fa-truck"></i>
                <span class="sb-label">Vendors</span>
            </a>
            @endpermission

            @permission('view-expenses')
            <a class="sb-item {{ request()->routeIs('expenses.*') ? 'active' : '' }}"
               href="{{ route('expenses.index') }}"
               data-label="Expenses">
                <i class="fa fa-chart-line"></i>
                <span class="sb-label">Expenses</span>
            </a>
            @endpermission

            {{-- Reports --}}
            @permission('view-reports')
            <div class="sb-section">Reports</div>

            <a class="sb-item {{ request()->is('*report*daily*') ? 'active' : '' }}"
               href="{{ route('sales.report', ['type' => 'daily']) }}"
               data-label="Daily Sales">
                <i class="fa fa-chart-bar"></i>
                <span class="sb-label">Daily Sales</span>
            </a>

            <a class="sb-item {{ request()->is('*report*credit*') ? 'active' : '' }}"
               href="{{ route('sales.report', ['type' => 'credit']) }}"
               data-label="Credit Sales">
                <i class="fa fa-file-invoice-dollar"></i>
                <span class="sb-label">Credit Sales</span>
            </a>

            <a class="sb-item {{ request()->is('*report*non-credit*') ? 'active' : '' }}"
               href="{{ route('sales.report', ['type' => 'non-credit']) }}"
               data-label="Non-Credit Sales">
                <i class="fa fa-file-alt"></i>
                <span class="sb-label">Non-Credit Sales</span>
            </a>
            @endpermission

            {{-- Settings --}}
            @anypermission('view-settings|manage-settings|manage-permissions|manage-shops')
            <div class="sb-section">Settings</div>

            @permission('manage-shops')
            <a class="sb-item {{ request()->routeIs('shops.settings') ? 'active' : '' }}"
               href="{{ route('shops.settings') }}"
               data-label="Shops">
                <i class="fa fa-store"></i>
                <span class="sb-label">Shops</span>
            </a>
            @endpermission

            @permission('manage-taxes')
            <a class="sb-item" href="#" data-label="Taxes">
                <i class="fa fa-percent"></i>
                <span class="sb-label">Taxes</span>
            </a>
            @endpermission

            @permission('manage-printers')
            <a class="sb-item" href="#" data-label="Printers">
                <i class="fa fa-print"></i>
                <span class="sb-label">Printers</span>
            </a>
            @endpermission

            @permission('manage-permissions')
            <a class="sb-item {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}"
               href="{{ route('admin.permissions.index') }}"
               data-label="Permissions">
                <i class="fa fa-shield-alt"></i>
                <span class="sb-label">Permissions</span>
            </a>
            @endpermission

            @permission('manage-settings')
            <a class="sb-item {{ request()->routeIs('settings.*') ? 'active' : '' }}"
               href="{{ route('settings.general') }}"
               data-label="General Settings">
                <i class="fa fa-sliders-h"></i>
                <span class="sb-label">General Settings</span>
            </a>
            @endpermission

            @endanypermission

            {{-- Legacy fallback
            @if(in_array(Auth::user()->role, ['admin','staff']) && !auth()->user()->hasPermission('view-customers'))
            <a class="sb-item" href="{{ route('customers.index') }}" data-label="Customers">
                <i class="fa fa-users"></i>
                <span class="sb-label">Customers (Legacy)</span>
            </a>
            @endif --}}

        </div>

        {{-- User footer --}}
        <div class="sb-footer">
            <div class="dropdown">
                <a class="sb-user" href="#" data-bs-toggle="dropdown">
                    <div class="sb-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="sb-user-info">
                        <div class="sb-user-name">{{ Auth::user()->name }}</div>
                        <div class="sb-user-role">
                           @if(auth()->user()->hasRole('super-admin'))
                                Super Admin
                            @elseif(auth()->user()->roles->isNotEmpty())
                                {{ ucfirst(auth()->user()->roles->first()->name) }}
                            @else
                                {{ ucfirst(Auth::user()->role ?? 'User') }}
                            @endif
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu mb-1">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fa fa-user me-2"></i> Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit">
                                <i class="fa fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

    </nav>

    {{-- Mobile overlay --}}
    <div id="sb-overlay" onclick="closeMobileSidebar()"></div>
    @endauth

    {{-- ── Main area ── --}}
    <div class="app-main">

        {{-- Top bar --}}
        @auth
        <div class="app-topbar d-none">
            {{-- Mobile toggle --}}
            <button id="mobile-toggle" onclick="openMobileSidebar()">
                <i class="fa fa-bars"></i>
            </button>

            <span class="page-title">@yield('page-title', 'Dashboard')</span>

            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="text-muted" style="font-size:13px">{{ now()->format('d M Y') }}</span>
            </div>
        </div>
        @endauth

        {{-- Page content --}}
        <div class="app-content">

            {{-- Flash messages --}}
            <div class="flash-stack">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-2" role="alert">
                    <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                    <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show mb-2" role="alert">
                    <i class="fa fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
            </div>

            @yield('content')
        </div>

        <footer class="text-center text-muted py-2 bg-light border-top" style="font-size:12px;flex-shrink:0">
            &copy; {{ date('Y') }} POS System | Powered by
            <a href="https://codecousins.com/" target="_blank" class="text-decoration-none">CodeCousins</a>
        </footer>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const SIDEBAR_KEY = 'sb_collapsed';

    function toggleSidebar() {
        const sb = document.getElementById('sidebar');
        sb.classList.toggle('collapsed');
        localStorage.setItem(SIDEBAR_KEY, sb.classList.contains('collapsed') ? '1' : '0');
    }

    function openMobileSidebar() {
        document.getElementById('sidebar').classList.add('mobile-open');
        document.getElementById('sb-overlay').classList.add('active');
    }

    function closeMobileSidebar() {
        document.getElementById('sidebar').classList.remove('mobile-open');
        document.getElementById('sb-overlay').classList.remove('active');
    }

    // Position user dropdown dynamically so it never gets clipped
    document.addEventListener('DOMContentLoaded', function () {
        const sbFooter = document.querySelector('.sb-footer');
        if (!sbFooter) return;

        sbFooter.addEventListener('show.bs.dropdown', function () {
            const sb = document.getElementById('sidebar');
            const menu = sbFooter.querySelector('.dropdown-menu');
            const sbWidth = sb ? sb.offsetWidth : 240;
            menu.style.left = (sbWidth + 4) + 'px';
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        if (localStorage.getItem(SIDEBAR_KEY) === '1') {
            document.getElementById('sidebar')?.classList.add('collapsed');
        }
    });
</script>

{{-- POS Exit Password Modal --}}
@auth
@if(session('pos_verified_shop'))
<div class="modal fade" id="posExitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 380px;">
        <div class="modal-content border-0" style="border-radius: 16px;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold"><i class="fa fa-lock me-2"></i>Exit POS Session</h5>
            </div>
            <div class="modal-body">
                <p class="text-muted small mb-3">Enter your password to exit the POS session.</p>
                <div id="posExitError" class="alert alert-danger d-none"></div>
                <input type="hidden" id="posExitRedirect">
                <div class="mb-3">
                    <label class="form-label fw-medium">Password</label>
                    <input type="password" id="posExitPassword" class="form-control" placeholder="Enter your password">
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Stay in POS</button>
                <button type="button" class="btn btn-danger" id="posExitConfirm">
                    <span id="posExitSpinner" class="spinner-border spinner-border-sm d-none me-1"></span>
                    Exit POS
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const posExitModal = new bootstrap.Modal(document.getElementById('posExitModal'), { backdrop: 'static', keyboard: false });

    // Intercept ALL sidebar nav links
    document.querySelectorAll('.sb-nav .sb-item, .sb-footer .dropdown-item').forEach(function(link) {
        link.addEventListener('click', function(e) {
            // Allow logout form to submit normally
            if (this.closest('form')) return;
            e.preventDefault();
            document.getElementById('posExitRedirect').value = this.href || '/dashboard';
            document.getElementById('posExitPassword').value = '';
            document.getElementById('posExitError').classList.add('d-none');
            posExitModal.show();
        });
    });

    // Intercept browser back button
    history.pushState(null, null, location.href);
    window.addEventListener('popstate', function() {
        history.pushState(null, null, location.href);
        document.getElementById('posExitRedirect').value = document.referrer || '/dashboard';
        document.getElementById('posExitPassword').value = '';
        document.getElementById('posExitError').classList.add('d-none');
        posExitModal.show();
    });

    // Confirm exit
    document.getElementById('posExitConfirm').addEventListener('click', function() {
        const password = document.getElementById('posExitPassword').value;
        const redirectTo = document.getElementById('posExitRedirect').value;
        const spinner = document.getElementById('posExitSpinner');
        const errorDiv = document.getElementById('posExitError');

        if (!password) {
            errorDiv.textContent = 'Please enter your password.';
            errorDiv.classList.remove('d-none');
            return;
        }

        spinner.classList.remove('d-none');
        this.disabled = true;

        fetch('{{ route("pos.exit") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ password: password, redirect_to: redirectTo })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                errorDiv.textContent = data.message;
                errorDiv.classList.remove('d-none');
                spinner.classList.add('d-none');
                document.getElementById('posExitConfirm').disabled = false;
            }
        });
    });
});
</script>
@endif
@endauth

@stack('scripts')
</body>
</html>