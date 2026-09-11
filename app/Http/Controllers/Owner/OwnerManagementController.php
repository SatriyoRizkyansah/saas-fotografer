<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OwnerManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'owner');

        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $owners = $query->paginate(15)->withQueryString();

        return view('admin.owners.index', compact('owners', 'search'));
    }

    public function toggleSubscription(Request $request, $id)
    {
        $owner = User::findOrFail($id);

        if ($owner->role !== 'owner') {
            return redirect()->back()->with('error', 'Invalid user.');
        }

        $owner->subscription_status = !$owner->subscription_status;
        $owner->save();

        $status = $owner->subscription_status ? 'activated' : 'deactivated';

        return redirect()->back()->with('success', "Owner subscription {$status} successfully.");
    }

    public function setExpiration(Request $request, $id)
    {
        $request->validate([
            'valid_until' => 'required|date|after:today',
        ]);

        $owner = User::findOrFail($id);

        if ($owner->role !== 'owner') {
            return redirect()->back()->with('error', 'Invalid user.');
        }

        $owner->subscription_valid_until = $request->valid_until;
        $owner->subscription_status = true;
        $owner->save();

        return redirect()->back()->with('success', 'Subscription expiration date updated successfully.');
    }
}
