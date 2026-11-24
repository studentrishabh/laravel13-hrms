
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit My Profile | EmployeeHub</title>

    <link rel="stylesheet" href="{{ asset('css/employee.css') }}">

    <style>
        .edit-card {
            max-width: 850px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
        }

        .edit-card h2 {
            margin-bottom: 8px;
        }

        .edit-subtitle {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .edit-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .edit-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .edit-group input,
        .edit-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            outline: none;
        }

        .edit-group input:focus,
        .edit-group select:focus {
            border-color: #2563eb;
        }

        .edit-actions {
            display: flex;
            gap: 12px;
            margin-top: 25px;
        }

        .save-btn, .cancel-btn {
            padding: 12px 22px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
        }

        .save-btn {
            background: #2563eb;
            color: white;
        }

        .cancel-btn {
            background: #e2e8f0;
            color: #334155;
        }

        .error-text {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
        }

        @media(max-width: 600px) {
            .edit-grid {
                grid-template-columns: 1fr;
            }

            .edit-card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<div class="employee-wrapper">

    <aside class="employee-sidebar">
        <div class="employee-brand">
            Employee<span>Hub</span>
        </div>

        <p class="sidebar-label">MAIN MENU</p>

        <nav class="employee-nav">
            <a href="{{ route('employee.dashboard') }}">
                🏠 Dashboard
            </a>

            <a href="{{ route('employee.profile.edit') }}" class="active">
                👤 Edit Profile
            </a>
        </nav>
    </aside>

    <main class="employee-main">

        <header class="employee-topbar">
            <h3>Edit My Profile</h3>
            <div class="employee-user">
                {{ auth()->user()->name }}
            </div>
        </header>

        <section class="employee-content">

            <div class="edit-card">
            @if(session('success'))
                <div style="background:#dcfce7; color:#166534; padding:12px; border-radius:8px; margin-bottom:20px;">
                    {{ session('success') }}
                </div>
            @endif
                            <h2>Personal Information</h2>

                <p class="edit-subtitle">
                    Update your personal contact details.
                </p>

                <form method="POST"
                    action="{{ route('employee.profile.update') }}">

                    @csrf
                    @method('PUT')

                    <div class="edit-grid">

                        <div class="edit-group">
                            <label>Full Name</label>
                            <input type="text"
                                   value="{{ $employee->name }}"
                                   disabled>
                        </div>

                        <div class="edit-group">
                            <label>Email Address</label>
                            <input type="email"
                                   value="{{ $employee->email }}"
                                   disabled>
                        </div>

                        <div class="edit-group">
                            <label>Phone Number</label>
                            <input type="text"
                                   name="phone"
                                   value="{{ old('phone', $employee->phone) }}"
                                   placeholder="Enter phone number">

                            @error('phone')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="edit-group">
                            <label>Gender</label>
                            <select name="gender">
                                <option value="">Select Gender</option>

                                <option value="Male"
                                    @selected(old('gender', $employee->gender) == 'Male')>
                                    Male
                                </option>

                                <option value="Female"
                                    @selected(old('gender', $employee->gender) == 'Female')>
                                    Female
                                </option>

                                <option value="Other"
                                    @selected(old('gender', $employee->gender) == 'Other')>
                                    Other
                                </option>
                            </select>
                        </div>

                    </div>

                    <div class="edit-actions">
                        <button type="submit" class="save-btn">
                            Save Changes
                        </button>

                        <a href="{{ route('employee.dashboard') }}"
                           class="cancel-btn">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>

        </section>

    </main>

</div>

</body>
</html>
