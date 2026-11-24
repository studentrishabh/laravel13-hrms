
@extends('layouts.app')

@section('title', 'Edit Employee')
@section('page-heading', 'Edit Employee')

@section('content')

<div class="page-heading">
    <div>
        <h1>Edit Employee</h1>
        <p>Update employee information and professional details.</p>
    </div>

    <a href="{{ route('employees.index') }}" class="btn btn-secondary">
        ← Back to Employees
    </a>
</div>


<div class="form-card">

    <div class="form-card-header">
        <div>
            <h3>Update Employee Information</h3>
            <p>Employee ID: {{ $employee->employee_code }}</p>
        </div>
        <div class="form-icon">✎</div>
    </div>

    <form action="{{ route('employees.update', $employee->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        {{-- Profile Photo --}}
        <div class="form-section-title">Profile Photo</div>

        <div class="form-group">
            <label>Current Profile Photo</label>

            <div class="profile-photo-preview">
                @if($employee->photo)
                   <img id="photoPreview"
     src="{{ $employee->photo
        ? asset('storage/' . $employee->photo)
        : '' }}"
     alt="{{ $employee->name }}"
     style="{{ $employee->photo ? '' : 'display:none;' }}">
                @else
                    <span>
                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                    </span>
                @endif
            </div>

            <label for="photo">Change Profile Photo</label>

            <input type="file"
                   name="photo"
                   id="photo"
                   accept="image/jpeg,image/png,image/jpg,image/webp">

            @error('photo')
                <span class="field-error">{{ $message }}</span>
            @enderror

            <small>Allowed: JPG, JPEG, PNG, WEBP. Maximum 2 MB.</small>
        </div>

        {{-- Personal Details --}}
        <div class="form-section-title">Personal Details</div>

        <div class="form-grid">

            <div class="form-group">
                <label>Employee ID *</label>
                <input type="text" name="employee_code"
                    value="{{ old('employee_code', $employee->employee_code) }}">
                @error('employee_code')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Full Name *</label>
                <input type="text" name="name"
                    value="{{ old('name', $employee->name) }}">
                @error('name')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Email Address *</label>
                <input type="email" name="email"
                    value="{{ old('email', $employee->email) }}">
                @error('email')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone"
                    value="{{ old('phone', $employee->phone) }}">
                @error('phone')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Gender</label>
                <select name="gender">
                    <option value="">Select gender</option>
                    @foreach(['Male', 'Female', 'Other'] as $gender)
                        <option value="{{ $gender }}"
                            @selected(old('gender', $employee->gender) == $gender)>
                            {{ $gender }}
                        </option>
                    @endforeach
                </select>
                @error('gender')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Joining Date *</label>
                <input type="date" name="joining_date"
                    value="{{ old('joining_date', $employee->joining_date) }}">
                @error('joining_date')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

        </div>

        {{-- Professional Details --}}
        <div class="form-section-title">Professional Details</div>

        <div class="form-grid">

            <div class="form-group">
                <label>Department *</label>
                <select name="department">
                    <option value="">Select department</option>
                    @foreach(['IT', 'HR', 'Finance', 'Marketing', 'Sales', 'Operations'] as $department)
                        <option value="{{ $department }}"
                            @selected(old('department', $employee->department) == $department)>
                            {{ $department }}
                        </option>
                    @endforeach
                </select>
                @error('department')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Designation *</label>
                <input type="text" name="designation"
                    value="{{ old('designation', $employee->designation) }}">
                @error('designation')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Monthly Salary (₹) *</label>
                <input type="number" name="salary"
                    value="{{ old('salary', $employee->salary) }}"
                    min="0" step="0.01">
                @error('salary')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Employment Status *</label>
                <select name="status">
                    <option value="active"
                        @selected(old('status', $employee->status) == 'active')>
                        Active
                    </option>
                    <option value="inactive"
                        @selected(old('status', $employee->status) == 'inactive')>
                        Inactive
                    </option>
                </select>
                @error('status')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

        </div>

        <div class="form-actions">
            <a href="{{ route('employees.index') }}"
               class="btn btn-secondary">
                Cancel
            </a>

            <button type="submit" class="btn btn-primary">
                Update Employee
            </button>
        </div>

    </form>
</div>
@endsection
