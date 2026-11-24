
@extends('layouts.app')

@section('title', 'Add Employee')
@section('page-heading', 'Add Employee')

@section('content')

<div class="page-heading">
    <div>
        <h1>Add New Employee</h1>
        <p>Enter employee information to create a new record.</p>
    </div>

    <a href="{{ route('employees.index') }}" class="btn btn-secondary">
        ← Back to Dashboard
    </a>
</div>

<div class="form-card">

    <div class="form-card-header">
        <div>
            <h3>Employee Information</h3>
            <p>Fields marked with * are required.</p>
        </div>
        <div class="form-icon">♙</div>
    </div>

  <form action="{{ route('employees.store') }}"
      method="POST"
      enctype="multipart/form-data">
        @csrf
<div class="form-group">
    <label for="photo">Profile Photo</label>

    <input type="file"
           name="photo"
           id="photo"
           accept="image/jpeg,image/png,image/jpg,image/webp">

    @error('photo')
        <span class="field-error">{{ $message }}</span>
    @enderror

    <small>Allowed formats: JPG, JPEG, PNG, WEBP. Maximum size: 2 MB.</small>
</div>
        <div class="form-section-title">Personal Details</div>

        <div class="form-grid">

            <div class="form-group">
                <label>Employee ID *</label>
                <input type="text" name="employee_code"
                    value="{{ old('employee_code') }}"
                    placeholder="EMP001">
                @error('employee_code')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Full Name *</label>
                <input type="text" name="name"
                    value="{{ old('name') }}"
                    placeholder="Enter full name">
              @error('name')
    <span class="field-error">{{ $message }}</span>
@enderror
            </div>

            <div class="form-group">
                <label>Email Address *</label>
                <input type="email" name="email"
                    value="{{ old('email') }}"
                    placeholder="example@gmail.com">
               @error('email')
    <span class="field-error">{{ $message }}</span>
@enderror
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone"
                    value="{{ old('phone') }}"
                    placeholder="Enter phone number">
                            @error('name')
    <span class="field-error">{{ $message }}</span>
@enderror
            </div>

            <div class="form-group">
                <label>Gender</label>
                <select name="gender">
                    <option value="">Select gender</option>
                    <option value="Male" @selected(old('gender') == 'Male')>Male</option>
                    <option value="Female" @selected(old('gender') == 'Female')>Female</option>
                    <option value="Other" @selected(old('gender') == 'Other')>Other</option>
                </select>
   @error('gender')
    <span class="field-error">{{ $message }}</span>
@enderror
            </div>

            <div class="form-group">
                <label>Joining Date *</label>
                <input type="date" name="joining_date"
                    value="{{ old('joining_date') }}">
                             @error('joining_date')
    <span class="field-error">{{ $message }}</span>
@enderror
            </div>

        </div>

        <div class="form-section-title">Professional Details</div>

        <div class="form-grid">

            <div class="form-group">
                <label>Department *</label>
                <select name="department">
                    <option value="">Select department</option>
                    @foreach(['IT', 'HR', 'Finance', 'Marketing', 'Sales', 'Operations'] as $department)
                        <option value="{{ $department }}"
                            @selected(old('department') == $department)>
                            {{ $department }}
                        </option>
                    @endforeach
               @error('department')
    <span class="field-error">{{ $message }}</span>
@enderror</select>
                
            </div>

            <div class="form-group">
                <label>Designation *</label>
                <input type="text" name="designation"
                    value="{{ old('designation') }}"
                    placeholder="e.g. PHP Laravel Developer">
               @error('designation')
    <span class="field-error">{{ $message }}</span>
@enderror
            </div>

            <div class="form-group">
                <label>Monthly Salary (₹) *</label>
                <input type="number" name="salary"
                    value="{{ old('salary') }}"
                    placeholder="30000" min="0" step="0.01">
                @error('salary')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Employment Status *</label>
                <select name="status">
                    <option value="active" @selected(old('status', 'active') == 'active')>Active</option>
                    <option value="inactive" @selected(old('status') == 'inactive')>Inactive</option>
                </select>
               @error('status')
    <span class="field-error">{{ $message }}</span>
@enderror
            </div>

        </div>

        <div class="form-actions">
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                Cancel
            </a>

            <button type="reset" class="btn btn-outline">
                Reset
            </button>

            <button type="submit" class="btn btn-primary">
                Save Employee
            </button>
        </div>

    </form>

</div>

@endsection
