<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index($productId)
    {
        $product = Product::with(['category', 'owner'])->findOrFail($productId);

        return view('customer.checkout', compact('product'));
    }

    public function store(Request $request, $productId)
    {
        $product = Product::with('owner')->findOrFail($productId);

        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'payment_proof'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        $transaction = Transaction::create([
            'uuid'           => (string) Str::uuid(),
            'owner_id'       => $product->owner_id,
            'product_id'     => $product->id,
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'payment_proof'  => $proofPath,
            'status'         => 'pending',
        ]);

        return redirect()->route('order.status', $transaction->uuid)
            ->with('success', 'Pesanan berhasil dibuat! Silakan tunggu validasi dari fotografer.');
    }

    /**
     * Handle booking submitted from the storefront modal.
     * On success, redirect to order status page.
     * On validation failure, redirect back to storefront with errors + open modal state.
     */
    public function storeFromStorefront(Request $request, $store_uuid, $productId)
    {
        $product = Product::with('owner')->findOrFail($productId);

        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'payment_proof'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        $transaction = Transaction::create([
            'uuid'           => (string) Str::uuid(),
            'owner_id'       => $product->owner_id,
            'product_id'     => $product->id,
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'payment_proof'  => $proofPath,
            'status'         => 'pending',
        ]);

        return redirect()->route('order.status', $transaction->uuid)
            ->with('success', 'Pesanan berhasil dibuat! Silakan tunggu validasi dari fotografer.');
    }

    public function orderStatus($uuid)
    {
        $transaction = Transaction::with(['product', 'owner'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        return view('customer.order-status', compact('transaction'));
    }
}
