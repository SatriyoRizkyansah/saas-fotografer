<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('owner_id', Auth::id())
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('owner.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->owner_id !== Auth::id()) {
            abort(403);
        }

        $transaction->load('product');

        return view('owner.transactions.show', compact('transaction'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        if ($transaction->owner_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:valid,rejected',
        ]);

        $transaction->update(['status' => $request->status]);

        $statusText = $request->status === 'valid' ? 'divalidasi' : 'ditolak';

        return redirect()->route('owner.transactions.index')->with('success', "Transaksi berhasil {$statusText}!");
    }
}
