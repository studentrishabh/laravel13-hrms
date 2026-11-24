
@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-heading', 'Dashboard')

@section('content')

<div class="page-heading">
    <div>
        <h1>Dashboard Overview</h1>
        <p>Here is what's happening with your employees today.</p>
    </div>

    <a href="{{ route('employees.create') }}" class="btn btn-primary">
        + Add Employee
    </a>
</div>

<!-- Statistics Cards -->
<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-top">
            <span>Total Employees</span>
            <div class="stat-icon purple">♙</div>
        </div>
        <h2>{{ $totalEmployees }}</h2>
        <small>All registered employees</small>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <span>Active Employees</span>
            <div class="stat-icon green">✓</div>
        </div>
        <h2>{{ $activeEmployees }}</h2>
        <small>Currently active</small>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <span>Inactive Employees</span>
            <div class="stat-icon orange">Ⅱ</div>
        </div>
        <h2>{{ $inactiveEmployees }}</h2>
        <small>Currently inactive</small>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <span>Departments</span>
            <div class="stat-icon blue">▦</div>
        </div>
        <h2>{{ $totalDepartments }}</h2>
        <small>Unique departments</small>
    </div>

</div>

<!-- Department Analytics -->
<div class="analytics-card">
    <div class="analytics-header">
        <div>
            <h3>Department Analytics</h3>
            <p>Employee distribution across departments</p>
        </div>

        <span class="analytics-label">Overview</span>
    </div>

    <div class="chart-container">
        <canvas id="departmentChart"></canvas>
    </div>

    @if($departmentStats->isEmpty())
        <p class="empty-state">No department data available yet.</p>
    @endif
</div>

<div class="recent-section">

    <div class="section-heading">
        <div>
            <h3>Recent Employees</h3>
            <p>Recently added employees</p>
        </div>

        <a href="{{ route('employees.index') }}">View All</a>
    </div>

    <div class="table-responsive">
        <table class="employee-table">
           <thead>
    <tr>
        <th>EMPLOYEE</th>
        <th>EMPLOYEE ID</th>
        <th>DEPARTMENT</th>
        <th>DESIGNATION</th>
        <th>STATUS</th>
        <th>JOINING DATE</th>
        <th>ACTIONS</th>
    </tr>
</thead>
            <tbody>
                @forelse($recentEmployees as $employee)
                    <tr>
                        <td>
                            <strong>{{ $employee->name }}</strong>
                            <br>
                            <small>{{ $employee->email }}</small>
                        </td>

                        <td>{{ $employee->department }}</td>
                        <td>{{ $employee->designation }}</td>
                        <td>{{ $employee->joining_date }}</td>

                        <td>
                            <span class="status-badge {{ $employee->status }}">
                                {{ ucfirst($employee->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            No employees available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- Search and Filters -->
<div class="filter-card">

    <form action="{{ route('employees.index') }}" method="GET"
          class="filter-form">

        <div class="search-box">
            <input
                type="text"
                id="employeeSearch"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search name, email or employee ID..." class="form-control"
            >
        </div>

        <select name="department">
            <option value="">All Departments</option>

            @foreach($departments as $department)
                <option value="{{ $department }}"
                    @selected(request('department') == $department)>
                    {{ $department }}
                </option>
            @endforeach
        </select>

        <select name="status">
            <option value="">All Status</option>
            <option value="active"
                @selected(request('status') == 'active')>
                Active
            </option>
            <option value="inactive"
                @selected(request('status') == 'inactive')>
                Inactive
            </option>
        </select>

        <button type="submit" class="btn btn-primary">
            Search
        </button>

        <a href="{{ route('employees.index') }}"
           class="btn btn-secondary">
            Reset
        </a>

    </form>

</div>

<form action="{{ route('employees.import') }}"
      method="POST"
      enctype="multipart/form-data"
      class="import-form">

    @csrf

    <input
        type="file"
        name="csv_file"
        accept=".csv,.txt"
        required
    >

    <button type="submit" class="btn-import">
        ↑ Import CSV
    </button>
    <a href="{{ route('employees.export') }}" class="btn-export">
    <span>↓</span> Export CSV
</a>
</form>

<!-- Employee Table -->
<div class="table-card">

    <div class="table-header">
        <div>
            <h3>Recent Employees</h3>
            <p>Latest employees added to the system</p>
        </div>

        <a href="{{ route('employees.index') }}" class="view-all">
            View All
        </a>
    </div>

<div class="recent-section">

    <div class="section-heading">
        <div>
            <h3>Recent Activity</h3>
            <p>Recently updated employee records</p>
        </div>
    </div>

    <div class="activity-list">

        @forelse($recentActivities as $activity)

            <div class="activity-item">

                <div class="activity-icon">↻</div>

                <div class="activity-content">
                    <strong>{{ $activity->name }}</strong>

                    <p>
                        Employee record last updated
                        {{ $activity->updated_at->diffForHumans() }}
                    </p>
                </div>

            </div>

        @empty
            <p class="empty-state">No recent activity available.</p>
        @endforelse

    </div>

</div>

  
<div class="table-responsive">
    <table>

        <thead>
            <tr>
                <th>
                    <a href="{{ route('employees.index', array_merge(request()->query(), [
                        'sort' => 'employee_code',
                        'direction' => ($sort === 'employee_code' && $direction === 'asc') ? 'desc' : 'asc'
                    ])) }}">
                        Employee ID ↕
                    </a>
                </th>

                <th>
                    <a href="{{ route('employees.index', array_merge(request()->query(), [
                        'sort' => 'name',
                        'direction' => ($sort === 'name' && $direction === 'asc') ? 'desc' : 'asc'
                    ])) }}">
                        Employee Name ↕
                    </a>
                </th>

                <th>Email</th>
                <th>Department</th>
                <th>Designation</th>

                <th>
                    <a href="{{ route('employees.index', array_merge(request()->query(), [
                        'sort' => 'salary',
                        'direction' => ($sort === 'salary' && $direction === 'asc') ? 'desc' : 'asc'
                    ])) }}">
                        Salary ↕
                    </a>
                </th>

                <th>
                    <a href="{{ route('employees.index', array_merge(request()->query(), [
                        'sort' => 'joining_date',
                        'direction' => ($sort === 'joining_date' && $direction === 'asc') ? 'desc' : 'asc'
                    ])) }}">
                        Joining Date ↕
                    </a>
                </th>

                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($employees as $employee)

                <tr>
                    {{-- Employee ID --}}
                    <td>{{ $employee->employee_code }}</td>

                    {{-- Employee Name --}}
                    <td>
                <div class="employee-info">

                    <div class="employee-avatar">
                        @if($employee->photo)
                            <img src="{{ asset('storage/' . $employee->photo) }}"
                                alt="{{ $employee->name }}"
                                class="employee-photo">
                        @else
                            {{ strtoupper(substr($employee->name, 0, 1)) }}
                        @endif
                    </div>

        <div>
            <strong>{{ $employee->name }}</strong>
            <small>{{ $employee->email }}</small>
        </div>

    </div>
</td>

                    {{-- Email --}}
                    <td>{{ $employee->email }}</td>

                    {{-- Department --}}
                    <td>{{ $employee->department }}</td>

                    {{-- Designation --}}
                    <td>{{ $employee->designation }}</td>

                    {{-- Salary --}}
                    <td>
                        <strong>₹{{ number_format($employee->salary, 2) }}</strong>
                    </td>

                    {{-- Joining Date --}}
                                <td>
                    {{ \Carbon\Carbon::parse($employee->joining_date)->format('d M, Y') }}
                </td>

                    {{-- Status --}}
                    <td>
                       <form action="{{ route('employees.toggleStatus', $employee->id) }}"
                    method="POST">
                    @csrf
                    @method('PATCH')

                    <button type="submit"
                        class="status-toggle-btn {{ $employee->status === 'active' ? 'btn-deactivate' : 'btn-activate' }}">
                        {{ $employee->status === 'active' ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="action-buttons">

                            <a href="{{ route('employees.show', $employee->id) }}"
                               class="action-btn view-btn">
                                View
                            </a>

                            <a href="{{ route('employees.edit', $employee->id) }}"
                               class="action-btn edit-btn">
                                Edit
                            </a>

                            <form action="{{ route('employees.destroy', $employee->id) }}"
                                  method="POST"
                                  class="delete-form">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        class="btn-delete"
                                        onclick="confirmDelete(this)">
                                    Delete
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="9" class="empty-state">
                        No employees found. Add your first employee!
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>
</div>


  <div class="pagination-wrapper">

    <div class="pagination-info">
        Showing {{ $employees->firstItem() ?? 0 }}
        to {{ $employees->lastItem() ?? 0 }}
        of {{ $employees->total() }} employees
    </div>

    {{ $employees->links('pagination::simple-tailwind') }}

</div>

</div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const chartElement = document.getElementById('departmentChart');

    if (!chartElement) {
        return;
    }

    const departmentLabels = @json($departmentStats->pluck('department'));
    const employeeCounts = @json($departmentStats->pluck('total'));

    if (departmentLabels.length === 0) {
        return;
    }

    new Chart(chartElement, {
        type: 'bar',

        data: {
            labels: departmentLabels,

            datasets: [{
                label: 'Employees',
                data: employeeCounts,
                backgroundColor: '#3b82f6',
                borderRadius: 8,
                barThickness: 35
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false
                }
            },

            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

});
</script>
