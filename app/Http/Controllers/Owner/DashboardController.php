<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalProducts = $user->products()->count();
        $pendingTransactions = $user->transactions()->where('status', 'pending')->count();
        $validTransactions = $user->transactions()->where('status', 'valid')->count();
        $totalRevenue = $user->transactions()->where('status', 'valid')->sum('products.price');

        return view('owner.dashboard', compact('totalProducts', 'pendingTransactions', 'validTransactions', 'totalRevenue'));
    }
}
