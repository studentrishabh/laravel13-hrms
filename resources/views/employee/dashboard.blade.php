
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee Dashboard | EmployeeHub</title>

    <link rel="stylesheet" href="{{ asset('css/employee.css') }}">
</head>

<body>

<div class="employee-wrapper">

    <!-- Sidebar -->
    <aside class="employee-sidebar">

        <div class="employee-brand">
            Employee<span>Hub</span>
        </div>

        <p class="sidebar-label">MAIN MENU</p>

       <nav class="employee-nav">

    <a href="{{ route('employee.dashboard') }}" class="active">
        🏠 Dashboard
    </a>

    <a href="#profile">
        👤 My Profile
    </a>

    <a href="{{ route('employee.profile.edit') }}">
        ✏️ Edit Profile
    </a>

</nav>

        <p class="sidebar-label">ACCOUNT</p>

        <nav class="employee-nav">
            <a href="#profile">
                ⚙️ Account Details
            </a>
        </nav>

    </aside>

    <!-- Main Content -->
    <main class="employee-main">

        <!-- Topbar -->
        <header class="employee-topbar">
            <h3>Employee Portal</h3>

            <div class="employee-user">
                Welcome, <strong>{{ auth()->user()->name }}</strong>
            </div>
        </header>

        <!-- Dashboard Content -->
        <section class="employee-content">

            <div class="employee-welcome">
                <h1>Hello, {{ auth()->user()->name }}! 👋</h1>

                <p>
                    Welcome to your EmployeeHub dashboard.
                    Have a productive day!
                </p>
            </div>

            <!-- Profile -->
            <div class="employee-profile-card" id="profile">

                <h2>My Account Details</h2>

              <div class="employee-profile-card" id="profile">

    <h2>My Professional Profile</h2>

    @php
        $employee = auth()->user()->employee;
    @endphp

    @if($employee)
    <div class="employee-profile-header">

    @if($employee->photo)
        <img
            src="{{ asset('storage/' . $employee->photo) }}"
            alt="{{ $employee->name }}"
            class="employee-avatar"
        >
    @else
        <div class="employee-avatar-placeholder">
            {{ strtoupper(substr($employee->name, 0, 1)) }}
        </div>
    @endif

    <div>
        <h3>{{ $employee->name }}</h3>
        <p>{{ $employee->designation }}</p>
    </div>

</div>

        <div class="profile-detail">
            <strong>Name:</strong>
            {{ $employee->name }}
        </div>

        <div class="profile-detail">
            <strong>Email:</strong>
            {{ $employee->email }}
        </div>

        <div class="profile-detail">
            <strong>Employee ID:</strong>
            {{ $employee->employee_code }}
        </div>

        <div class="profile-detail">
            <strong>Department:</strong>
            {{ $employee->department }}
        </div>

        <div class="profile-detail">
            <strong>Designation:</strong>
            {{ $employee->designation }}
        </div>

        <div class="profile-detail">
            <strong>Phone:</strong>
            {{ $employee->phone ?? 'Not Added' }}
        </div>

        <div class="profile-detail">
            <strong>Status:</strong>
            {{ ucfirst($employee->status) }}
        </div>

    @else

        <p>No employee profile is linked to your account yet.</p>

    @endif

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="employee-logout">
            Logout
        </button>
    </form>

</div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="employee-logout">
                        Logout
                    </button>
                </form>

            </div>

        </section>

    </main>

</div>

</body>
</html>
