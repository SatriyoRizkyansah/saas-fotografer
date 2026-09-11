<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalOwners = \App\Models\User::where('role', 'owner')->count();
        $activeOwners = \App\Models\User::where('role', 'owner')->where('subscription_status', true)->count();
        $pendingOwners = \App\Models\User::where('role', 'owner')->whereNull('subscription_status')->count();
        
        $recentOwners = \App\Models\User::where('role', 'owner')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalOwners', 
            'activeOwners', 
            'pendingOwners', 
            'recentOwners'
        ));
    }
}
