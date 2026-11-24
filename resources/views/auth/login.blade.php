
@extends('layouts.auth')

@section('title', 'Login | EmployeeHub')

@section('content')

<div class="auth-container">

    <div class="auth-left">
        <div class="auth-brand">
            <div class="brand-logo">E</div>
            <span>EmployeeHub</span>
        </div>

        <div class="auth-left-content">
            <span class="welcome-label">YOUR WORKPLACE, CONNECTED</span>

            <h1>Welcome back<br>to EmployeeHub.</h1>

            <p>
                Access your workspace, manage your profile
                and stay connected with your organization.
            </p>

            <div class="auth-feature"><span>✓</span> Secure login system</div>
            <div class="auth-feature"><span>✓</span> Role-based dashboard</div>
            <div class="auth-feature"><span>✓</span> Employee management</div>
        </div>

        <div class="auth-copyright">
            © {{ date('Y') }} EmployeeHub. All rights reserved.
        </div>
    </div>

    <div class="auth-right">

        <div class="register-card">

            <div class="mobile-brand">EmployeeHub</div>

            <div class="form-heading">
                <span class="form-label">WELCOME BACK</span>
                <h2>Sign in to your account</h2>
                <p>Select your portal and enter your login details.</p>
            </div>

            @if ($errors->any())
                <div class="auth-error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('status'))
                <div class="auth-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="login-portal">
                <button type="button"
                        class="portal-btn active"
                        data-role="Employee">
                    Employee
                </button>

                <button type="button"
                        class="portal-btn"
                        data-role="Admin">
                    Admin
                </button>
            </div>

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <input type="hidden" name="login_role"
                       id="loginRole" value="Employee">

                <div class="auth-field">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="name@example.com"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>

                <div class="auth-field">
                    <div class="label-row">
                        <label for="password">Password</label>
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    </div>

                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >

                        <button type="button"
                                class="password-toggle"
                                data-target="password">
                            Show
                        </button>
                    </div>
                </div>

                <label class="remember-option">
                    <input type="checkbox" name="remember" value="1">
                    <span>Remember me</span>
                </label>

                <button type="submit" class="auth-submit">
                    Sign In <span>→</span>
                </button>

            </form>

            <div class="auth-switch">
                Don't have an account?
                <a href="{{ route('register') }}">Create account</a>
            </div>

            <div class="auth-security">
                🔒 Your login details are protected.
            </div>

        </div>
    </div>

</div>

@endsection
