<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    // Display all employees


public function index(Request $request)
{
    $query = Employee::query();

    // Search
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('employee_code', 'like', "%{$search}%");
        });
    }

    // Department filter
    if ($request->filled('department')) {
        $query->where('department', $request->department);
    }

    // Status filter
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Sorting: only allow approved database columns
    $allowedSortColumns = [
        'name',
        'employee_code',
        'salary',
        'joining_date',
        'created_at',
    ];

    $sort = $request->get('sort', 'created_at');

    if (!in_array($sort, $allowedSortColumns, true)) {
        $sort = 'created_at';
    }

    $direction = $request->get('direction', 'desc');

    if (!in_array($direction, ['asc', 'desc'], true)) {
        $direction = 'desc';
    }

    $employees = $query
        ->orderBy($sort, $direction)
        ->paginate(10)
        ->withQueryString();

    // Dashboard statistics

    // Department-wise employee statistics
$departmentStats = Employee::select('department')
    ->selectRaw('COUNT(*) as total')
    ->groupBy('department')
    ->orderBy('department')
    ->get();
    $totalEmployees = Employee::count();
    $activeEmployees = Employee::where('status', 'active')->count();
    $inactiveEmployees = Employee::where('status', 'inactive')->count();

    $totalDepartments = Employee::distinct('department')->count('department');

    $departments = Employee::select('department')
        ->distinct()
        ->orderBy('department')
        ->pluck('department');
// Recent employees
$recentEmployees = Employee::latest()
    ->take(5)
    ->get();

// Recent employee activity
$recentActivities = Employee::latest('updated_at')
    ->take(5)
    ->get();
   return view('employee.index', compact(
    'employees',
    'totalEmployees',
    'activeEmployees',
    'inactiveEmployees',
    'totalDepartments',
    'departments',
    'sort',
    'direction',
    'departmentStats',
    'recentEmployees',
    'recentActivities',
));
}



    // Show create form
    public function create()
    {
        return view('employee.create');
    }

    // Store new employee
public function store(Request $request)
{
    $validated = $request->validate([
        'employee_code' => 'required|string|max:50|unique:employees,employee_code',
        'name' => 'required|string|max:100',
        'email' => 'required|email|max:100|unique:employees,email',
        'phone' => 'nullable|string|max:20',
        'gender' => 'nullable|in:Male,Female,Other',
        'department' => 'required|string|max:100',
        'designation' => 'required|string|max:100',
        'salary' => 'required|numeric|min:0',
        'joining_date' => 'required|date',
        'status' => 'required|in:active,inactive',
    ], [
        'employee_code.required' => 'Please enter employee ID.',
        'employee_code.unique' => 'This employee ID already exists.',
        'name.required' => 'Employee name is required.',
        'email.required' => 'Email address is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already registered.',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'department.required' => 'Please select a department.',
        'designation.required' => 'Please enter designation.',
        'salary.required' => 'Please enter employee salary.',
        'salary.numeric' => 'Salary must be a valid number.',
        'salary.min' => 'Salary cannot be negative.',
        'joining_date.required' => 'Please select joining date.',
        'joining_date.date' => 'Please enter a valid joining date.',
    ]);

   if ($request->hasFile('photo')) {
    $validated['photo'] = $request->file('photo')
        ->store('employees', 'public');
}

Employee::create($validated);
    return redirect()
        ->route('employee.index')
        ->with('success', 'Employee created successfully!');
}


    // Show employee details
    public function show(Employee $employee)
    {
        return view('employee.show', compact('employee'));
    }

    // Show edit form
    public function edit(Employee $employee)
    {
        return view('employee.edit', compact('employee'));
    }

    // Update employee
   public function update(Request $request, Employee $employee)
   {
    $validated = $request->validate([
        'employee_code' => [
            'required',
            'string',
            'max:50',
            Rule::unique('employees', 'employee_code')->ignore($employee->id),
        ],
        'name' => 'required|string|max:100',
        'email' => [
            'required',
            'email',
            'max:100',
            Rule::unique('employees', 'email')->ignore($employee->id),
        ],
        'phone' => 'nullable|string|max:20',
        'gender' => 'nullable|in:Male,Female,Other',
        'department' => 'required|string|max:100',
        'designation' => 'required|string|max:100',
        'salary' => 'required|numeric|min:0',
        'joining_date' => 'required|date',
        'status' => 'required|in:active,inactive',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    if ($request->hasFile('photo')) {

        // Delete old photo
        if ($employee->photo) {
            \Illuminate\Support\Facades\Storage::disk('public')
                ->delete($employee->photo);
        }

        // Store new photo
        $validated['photo'] = $request->file('photo')
            ->store('employees', 'public');
    }

    $employee->update($validated);

    return redirect()
        ->route('employees.show', $employee->id)
        ->with('success', 'Employee updated successfully!');
}

    // Delete employee
   public function destroy(Employee $employee)
    {
    $employee->delete();

    return redirect()
        ->route('employee.index')
         ->with('success', 'Employee moved to trash successfully!');
}


public function export()
{
    $employees = Employee::orderBy('id', 'desc')->get();

    $fileName = 'employees_' . now()->format('Y_m_d_H_i_s') . '.csv';

    $headers = [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Disposition' => "attachment; filename=\"$fileName\"",
    ];

    $columns = [
        'Employee Code',
        'Name',
        'Email',
        'Phone',
        'Gender',
        'Department',
        'Designation',
        'Salary',
        'Joining Date',
        'Status',
    ];

    $callback = function () use ($employees, $columns) {

        $file = fopen('php://output', 'w');

        // Excel UTF-8 support
        fwrite($file, "\xEF\xBB\xBF");

        fputcsv($file, $columns);

        foreach ($employees as $employee) {
            fputcsv($file, [
                $employee->employee_code,
                $employee->name,
                $employee->email,
                $employee->phone,
                $employee->gender,
                $employee->department,
                $employee->designation,
                $employee->salary,
                $employee->joining_date,
                $employee->status,
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}


public function import(Request $request)
{
    // Validate uploaded file
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt|max:2048',
    ]);

    $handle = fopen($request->file('csv_file')->getRealPath(), 'r');

    if ($handle === false) {
        return back()->with('error', 'Unable to read CSV file.');
    }

    // Read CSV headings
    $header = fgetcsv($handle);

    if (!$header) {
        fclose($handle);
        return back()->with('error', 'CSV file is empty.');
    }

    // Remove UTF-8 BOM from first heading
    $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);

    $expectedHeaders = [
        'Employee Code',
        'Name',
        'Email',
        'Phone',
        'Gender',
        'Department',
        'Designation',
        'Salary',
        'Joining Date',
        'Status',
    ];

    if ($header !== $expectedHeaders) {
        fclose($handle);
        return back()->with(
            'error',
            'Invalid CSV format. Please use the Employee Export CSV template.'
        );
    }

    $rows = [];
    $rowNumber = 1;
    $employeeCodes = [];
    $emails = [];

    while (($data = fgetcsv($handle)) !== false) {

        $rowNumber++;

        // Skip completely empty rows
        if (count(array_filter($data, fn($value) => trim((string) $value) !== '')) === 0) {
            continue;
        }

        if (count($data) !== count($expectedHeaders)) {
            fclose($handle);
            return back()->with(
                'error',
                "Invalid number of columns at CSV row {$rowNumber}."
            );
        }

        $row = array_combine($expectedHeaders, $data);

        $employee = [
            'employee_code' => trim($row['Employee Code']),
            'name' => trim($row['Name']),
            'email' => trim($row['Email']),
            'phone' => trim($row['Phone']) ?: null,
            'gender' => trim($row['Gender']) ?: null,
            'department' => trim($row['Department']),
            'designation' => trim($row['Designation']),
            'salary' => trim($row['Salary']),
            'joining_date' => trim($row['Joining Date']),
            'status' => strtolower(trim($row['Status'])),
        ];

        // Check duplicate values inside the uploaded CSV
        if (
            in_array($employee['employee_code'], $employeeCodes, true) ||
            in_array($employee['email'], $emails, true)
        ) {
            fclose($handle);
            return back()->with(
                'error',
                "Duplicate Employee Code or Email found at CSV row {$rowNumber}."
            );
        }

        $employeeCodes[] = $employee['employee_code'];
        $emails[] = $employee['email'];

        // Validate each employee
        $validator = Validator::make($employee, [
            'employee_code' => 'required|string|max:255|unique:employees,employee_code',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Other',
            'department' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'joining_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            fclose($handle);

            return back()->with(
                'error',
                "Validation failed at CSV row {$rowNumber}: " .
                $validator->errors()->first()
            );
        }

        $rows[] = $employee;
    }

    fclose($handle);

    if (empty($rows)) {
        return back()->with('error', 'No employee records found in CSV.');
    }

    // Insert all employees together
    DB::transaction(function () use ($rows) {
        foreach ($rows as $employee) {
            Employee::create($employee);
        }
    });

    return redirect()
        ->route('employees.index')
        ->with('success', count($rows) . ' employees imported successfully!');
}


// Show deleted employees
public function trash()
{
    $employees = Employee::onlyTrashed()
        ->latest('deleted_at')
        ->paginate(10);

    return view('employees.trash', compact('employees'));
}

// Restore employee
public function restore($id)
{
    $employee = Employee::onlyTrashed()->findOrFail($id);

    $employee->restore();

    return redirect()
        ->route('employee.trash')
        ->with('success', 'Employee restored successfully!');
}

// Permanently delete employee
public function forceDelete($id)
{
    $employee = Employee::onlyTrashed()->findOrFail($id);

    $employee->forceDelete();

    return redirect()
        ->route('employee.trash')
        ->with('success', 'Employee permanently deleted!');
}
public function toggleStatus(Employee $employee)
{
    $employee->status = $employee->status === 'active'
        ? 'inactive'
        : 'active';

    $employee->save();

    return redirect()->back()
        ->with('success', 'Employee status updated successfully!');
}


}