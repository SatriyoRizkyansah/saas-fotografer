<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\OwnerPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $methods = OwnerPaymentMethod::where('owner_id', Auth::id())
            ->orderByDesc('is_default')
            ->orderByDesc('is_active')
            ->latest()
            ->get();

        return view('owner.payment-methods.index', compact('methods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name'      => ['required', 'string', 'max:100'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_name'   => ['required', 'string', 'max:150'],
            'type'           => ['required', 'in:bank,gopay,ovo,dana,shopeepay,qris,other'],
            'is_default'     => ['boolean'],
        ]);

        // Kalau set default, lepas default yang lain
        if ($request->boolean('is_default')) {
            OwnerPaymentMethod::where('owner_id', Auth::id())->update(['is_default' => false]);
        }

        OwnerPaymentMethod::create([
            'owner_id'       => Auth::id(),
            'bank_name'      => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name'   => $request->account_name,
            'type'           => $request->type,
            'is_default'     => $request->boolean('is_default'),
            'is_active'      => true,
        ]);

        return redirect()->route('owner.payment-methods.index')
            ->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }

    public function update(Request $request, OwnerPaymentMethod $paymentMethod)
    {
        if ($paymentMethod->owner_id !== Auth::id()) abort(403);

        $request->validate([
            'bank_name'      => ['required', 'string', 'max:100'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_name'   => ['required', 'string', 'max:150'],
            'type'           => ['required', 'in:bank,gopay,ovo,dana,shopeepay,qris,other'],
            'is_default'     => ['boolean'],
        ]);

        if ($request->boolean('is_default')) {
            OwnerPaymentMethod::where('owner_id', Auth::id())
                ->where('id', '!=', $paymentMethod->id)
                ->update(['is_default' => false]);
        }

        $paymentMethod->update([
            'bank_name'      => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name'   => $request->account_name,
            'type'           => $request->type,
            'is_default'     => $request->boolean('is_default'),
        ]);

        return redirect()->route('owner.payment-methods.index')
            ->with('success', 'Metode pembayaran berhasil diperbarui!');
    }

    public function toggleActive(OwnerPaymentMethod $paymentMethod)
    {
        if ($paymentMethod->owner_id !== Auth::id()) abort(403);

        $paymentMethod->update(['is_active' => !$paymentMethod->is_active]);

        $status = $paymentMethod->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Metode pembayaran berhasil {$status}!");
    }

    public function setDefault(OwnerPaymentMethod $paymentMethod)
    {
        if ($paymentMethod->owner_id !== Auth::id()) abort(403);

        OwnerPaymentMethod::where('owner_id', Auth::id())->update(['is_default' => false]);
        $paymentMethod->update(['is_default' => true, 'is_active' => true]);

        return redirect()->back()->with('success', 'Metode pembayaran utama berhasil diubah!');
    }

    public function destroy(OwnerPaymentMethod $paymentMethod)
    {
        if ($paymentMethod->owner_id !== Auth::id()) abort(403);

        $paymentMethod->delete();

        return redirect()->route('owner.payment-methods.index')
            ->with('success', 'Metode pembayaran berhasil dihapus!');
    }
}
