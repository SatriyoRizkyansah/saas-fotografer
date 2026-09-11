<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

trait RedirectToDashboard
{
    /**
     * Redirect user to appropriate dashboard based on their role.
     */
    protected function redirectToDashboard(?User $user = null): RedirectResponse
    {
        $user = $user ?? request()->user();

        if ($user && $user->role === 'super_admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('owner.dashboard'));
    }
}
