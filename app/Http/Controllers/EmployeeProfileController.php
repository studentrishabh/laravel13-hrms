<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeProfileController extends Controller
{
    // Show Profile Edit Page
    public function edit()
    {
        $user = Auth::user();

        $employee = $user->employee;

        if (!$employee) {
            abort(404, 'Employee profile not found.');
        }

        return view('employee.profile-edit', compact('employee'));
    }

    // Update Employee Profile
    public function update(Request $request)
    {
        $user = Auth::user();

        $employee = $user->employee;

        if (!$employee) {
            abort(404, 'Employee profile not found.');
        }

        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Other',
        ]);

        $employee->update($validated);

        return redirect()
            ->route('employee.profile.edit')
            ->with('success', 'Profile updated successfully!');
    }
}
