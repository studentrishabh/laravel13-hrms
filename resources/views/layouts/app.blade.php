
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') | EmployeeHub</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="app-wrapper">

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-icon">E</div>
            <span>EmployeeHub</span>
        </div>

        <div class="sidebar-label">MAIN MENU</div>
        <form action="{{ route('logout') }}" method="POST" class="sidebar-logout-form">
    @csrf

    <button type="submit" class="sidebar-logout-btn">
        <span>↪</span>
        <span>Logout</span>
    </button>
</form>
<nav class="sidebar-nav">

    <a href="{{ route('dashboard') }}"
       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <span class="nav-icon">▦</span>
        <h2>@yield('page-heading', 'Dashboard')</h2>
    </a>

    <a href="{{ route('employees.index') }}"
       class="nav-link {{ request()->routeIs('employees.index', 'employees.show', 'employees.edit') ? 'active' : '' }}">
        <span class="nav-icon">♙</span>
        <span>Employees</span>
    </a>

    <a href="{{ route('employees.create') }}"
       class="nav-link {{ request()->routeIs('employees.create') ? 'active' : '' }}">
        <span class="nav-icon">＋</span>
        <span>Add Employee</span>
    </a>

    <a href="{{ route('employees.trash') }}"
       class="nav-link {{ request()->routeIs('employees.trash') ? 'active' : '' }}">
        <span class="nav-icon">▤</span>
        <span>Trash</span>
    </a>

</nav>

        <div class="sidebar-footer">
            <div class="profile-avatar">A</div>
            <div>
                <strong>Admin User</strong>
                <small>Administrator</small>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" id="menuToggle">☰</button>
                <div>
                    <h2>@yield('page-heading', 'Dashboard')</h2>
                    <p>Welcome back! Manage your workforce.</p>
                </div>
            </div>

            <div class="topbar-right">
                <span class="admin-name">Admin</span>
                <div class="profile-avatar">A</div>
            </div>
        </header>

        <section class="content-area">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    Please check the form for validation errors.
                </div>
            @endif

            @yield('content')

        </section>

        <footer class="footer">
            © {{ date('Y') }} EmployeeHub. All rights reserved.
        </footer>

    </main>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
