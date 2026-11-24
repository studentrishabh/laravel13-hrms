<?php

namespace App\Http\Responses;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasRole('Admin')) {
            return redirect()->route('dashboard');
        }

        if ($user->hasRole('Employee')) {
            return redirect()->route('employee.dashboard');
        }

        Auth::logout();

        return redirect()->route('login');
    }
}
