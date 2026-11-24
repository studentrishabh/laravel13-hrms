
@extends('layouts.auth')

@section('title', 'Create Account | EmployeeHub')

@section('content')

<div class="auth-container">

    <div class="auth-left">
        <div class="auth-brand">
            <div class="brand-logo">E</div>
            <span>EmployeeHub</span>
        </div>

        <div class="auth-left-content">
            <span class="welcome-label">WELCOME TO EMPLOYEEHUB</span>

            <h1>Build better<br>workplaces together.</h1>

            <p>
                Manage your employee profile and stay connected
                with your organization through one secure platform.
            </p>

            <div class="auth-feature">
                <span>✓</span> Secure employee portal
            </div>

            <div class="auth-feature">
                <span>✓</span> Easy profile management
            </div>

            <div class="auth-feature">
                <span>✓</span> Modern workplace experience
            </div>
        </div>

        <div class="auth-copyright">
            © {{ date('Y') }} EmployeeHub. All rights reserved.
        </div>
    </div>

    <div class="auth-right">

        <div class="register-card">

            <div class="mobile-brand">EmployeeHub</div>

            <div class="form-heading">
                <span class="form-label">GET STARTED</span>
                <h2>Create your account</h2>
                <p>Enter your details to register as an employee.</p>
            </div>

            @if ($errors->any())
                <div class="auth-error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="auth-field">
                    <label for="name">Full Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Enter your full name"
                        autocomplete="name"
                        required
                        autofocus
                    >
                    @error('name')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="name@example.com"
                        autocomplete="email"
                        required
                    >
                    @error('email')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Create a strong password"
                            autocomplete="new-password"
                            required
                        >
                        <button type="button" class="password-toggle"
                                data-target="password">Show</button>
                    </div>
                    @error('password')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="password_confirmation">Confirm Password</label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Confirm your password"
                            autocomplete="new-password"
                            required
                        >
                        <button type="button" class="password-toggle"
                                data-target="password_confirmation">Show</button>
                    </div>
                </div>

                <button type="submit" class="auth-submit">
                    Create Account <span>→</span>
                </button>

            </form>

            <div class="auth-switch">
                Already have an account?
                <a href="{{ route('login') }}">Sign in</a>
            </div>

            <div class="auth-security">
                <span>🔒</span>
                Your account is protected with secure authentication.
            </div>

        </div>
    </div>

</div>

@endsection
