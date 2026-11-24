
@extends('layouts.app')

@section('title', 'Employee Details')
@section('page-heading', 'Employee Details')

@section('content')

<div class="page-heading">
    <div>
        <h1>Employee Profile</h1>
        <p>Complete employee information and employment details.</p>
    </div>

    <div class="profile-actions">
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">
            ← Back
        </a>

        <a href="{{ route('employees.edit', $employee->id) }}"
           class="btn btn-primary">
            Edit Employee
        </a>
        <button type="button" onclick="window.print()" class="print-btn">
    Print Profile
</button>
    </div>
</div>

<div class="profile-card">
<div class="profile-header">

    <div class="profile-photo">
        @if($employee->photo)
            <img src="{{ asset('storage/' . $employee->photo) }}"
                 alt="{{ $employee->name }}">
        @else
            <span>
                {{ strtoupper(substr($employee->name, 0, 1)) }}
            </span>
        @endif
    </div>

    <div class="profile-info">
        <h2>{{ $employee->name }}</h2>
        <p>{{ $employee->email }}</p>
        <span class="status-badge {{ $employee->status }}">
            {{ ucfirst($employee->status) }}
        </span>
    </div>

</div>

    <div class="profile-section">
        <h3>Personal Information</h3>

        <div class="profile-grid">
            <div class="profile-item">
                <label>Employee ID</label>
                <strong>{{ $employee->employee_code }}</strong>
            </div>

            <div class="profile-item">
                <label>Full Name</label>
                <strong>{{ $employee->name }}</strong>
            </div>

            <div class="profile-item">
                <label>Email Address</label>
                <strong>{{ $employee->email }}</strong>
            </div>

            <div class="profile-item">
                <label>Phone Number</label>
                <strong>{{ $employee->phone ?? 'Not provided' }}</strong>
            </div>

            <div class="profile-item">
                <label>Gender</label>
                <strong>{{ $employee->gender ?? 'Not provided' }}</strong>
            </div>

            <div class="profile-item">
                <label>Joining Date</label>
                <strong>{{ $employee->joining_date }}</strong>
            </div>
        </div>
    </div>

    <div class="profile-section">
        <h3>Professional Information</h3>

        <div class="profile-grid">
            <div class="profile-item">
                <label>Department</label>
                <strong>{{ $employee->department }}</strong>
            </div>

            <div class="profile-item">
                <label>Designation</label>
                <strong>{{ $employee->designation }}</strong>
            </div>

            <div class="profile-item">
                <label>Monthly Salary</label>
                <strong>₹{{ number_format((float) $employee->salary, 2) }}</strong>
            </div>

            <div class="profile-item">
                <label>Employment Status</label>
                <strong>{{ ucfirst($employee->status) }}</strong>
            </div>
        </div>
    </div>

    <div class="profile-section">
        <h3>System Information</h3>

        <div class="profile-grid">
            <div class="profile-item">
                <label>Created At</label>
                <strong>{{ $employee->created_at->format('d M Y, h:i A') }}</strong>
            </div>

            <div class="profile-item">
                <label>Last Updated</label>
                <strong>{{ $employee->updated_at->format('d M Y, h:i A') }}</strong>
            </div>
        </div>
    </div>

</div>

@endsection
