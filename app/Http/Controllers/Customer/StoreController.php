<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\OwnerSetting;
use App\Models\Product;

class StoreController extends Controller
{
    public function show($store_uuid)
    {
        $setting = OwnerSetting::whereHas('owner', function($q) use ($store_uuid) {
            $q->where('store_uuid', $store_uuid);
        })->with('owner')->firstOrFail();

        $products = Product::where('owner_id', $setting->owner_id)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('storefront.show', compact('setting', 'products'));
    }
}
