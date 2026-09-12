<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\OwnerPaymentMethod;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index($productId)
    {
        $product        = Product::with(['category', 'owner'])->findOrFail($productId);
        $paymentMethods = OwnerPaymentMethod::where('owner_id', $product->owner_id)
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->get();

        return view('customer.checkout', compact('product', 'paymentMethods'));
    }

    public function store(Request $request, $productId)
    {
        $product = Product::with('owner')->findOrFail($productId);

        $request->validate([
            'customer_name'     => ['required', 'string', 'max:255'],
            'customer_email'    => ['required', 'email', 'max:255'],
            'customer_phone'    => ['required', 'string', 'max:20'],
            'payment_method_id' => ['required', 'exists:owner_payment_methods,id'],
            'payment_proof'     => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ]);

        // Pastikan payment method milik owner yang sama
        $paymentMethod = OwnerPaymentMethod::where('id', $request->payment_method_id)
            ->where('owner_id', $product->owner_id)
            ->where('is_active', true)
            ->firstOrFail();

        $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        $transaction = Transaction::create([
            'uuid'              => (string) Str::uuid(),
            'owner_id'          => $product->owner_id,
            'product_id'        => $product->id,
            'payment_method_id' => $paymentMethod->id,
            'customer_name'     => $request->customer_name,
            'customer_email'    => $request->customer_email,
            'customer_phone'    => $request->customer_phone,
            'payment_proof'     => $proofPath,
            'status'            => 'pending',
        ]);

        return redirect()->route('order.status', $transaction->uuid)
            ->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi.');
    }

    /**
     * Booking dari storefront modal.
     */
    public function storeFromStorefront(Request $request, $store_uuid, $productId)
    {
        $product = Product::with('owner')->findOrFail($productId);

        $request->validate([
            'customer_name'     => ['required', 'string', 'max:255'],
            'customer_email'    => ['required', 'email', 'max:255'],
            'customer_phone'    => ['required', 'string', 'max:20'],
            'payment_method_id' => ['required', 'exists:owner_payment_methods,id'],
            'payment_proof'     => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ]);

        $paymentMethod = OwnerPaymentMethod::where('id', $request->payment_method_id)
            ->where('owner_id', $product->owner_id)
            ->where('is_active', true)
            ->firstOrFail();

        $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        $transaction = Transaction::create([
            'uuid'              => (string) Str::uuid(),
            'owner_id'          => $product->owner_id,
            'product_id'        => $product->id,
            'payment_method_id' => $paymentMethod->id,
            'customer_name'     => $request->customer_name,
            'customer_email'    => $request->customer_email,
            'customer_phone'    => $request->customer_phone,
            'payment_proof'     => $proofPath,
            'status'            => 'pending',
        ]);

        return redirect()->route('order.status', $transaction->uuid)
            ->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi.');
    }

    public function orderStatus($uuid)
    {
        $transaction = Transaction::with(['product', 'owner', 'paymentMethod'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        return view('customer.order-status', compact('transaction'));
    }
}
