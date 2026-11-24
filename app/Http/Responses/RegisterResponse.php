<?php

namespace App\Http\Responses;

use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
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

        return redirect()->route('login');
    }
}
