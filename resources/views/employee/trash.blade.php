
@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h2>Deleted Employees</h2>
        <p>Restore or permanently delete employees.</p>
    </div>

    <a href="{{ route('employees.index') }}" class="btn-export">
        Back to Employees
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="employee-table">
            <thead>
                <tr>
                    <th>Employee Code</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Deleted At</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($employees as $employee)
                    <tr>
                        <td>{{ $employee->employee_code }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->department }}</td>
                        <td>{{ $employee->deleted_at->format('d M Y, h:i A') }}</td>

                        <td>
                            <div class="action-buttons">

                                <form action="{{ route('employees.restore', $employee->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="btn-edit">
                                        Restore
                                    </button>
                                </form>

                                <form action="{{ route('employees.forceDelete', $employee->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Permanently delete this employee?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-delete">
                                        Delete Forever
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            No deleted employees found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $employees->links('pagination::simple-tailwind') }}
</div>

@endsection
