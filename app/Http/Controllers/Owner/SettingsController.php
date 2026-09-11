<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\OwnerSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $setting = $request->user()->ownerSetting;

        if (!$setting) {
            $setting = OwnerSetting::create([
                'owner_id' => $request->user()->id,
            ]);
        }

        // Get or generate store URL
        $storeUrl = null;
        if ($setting->owner && $setting->owner->store_uuid) {
            $storeUrl = route('storefront.show', $setting->owner->store_uuid);
        }

        return view('owner.settings.index', compact('setting', 'storeUrl'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'nullable|string|max:255',
            'store_description' => 'nullable|string',
            'brand_color' => 'nullable|regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i',
            'social_links.*' => 'nullable|url',
            'is_published' => 'boolean',
        ]);

        $setting = $request->user()->ownerSetting;

        if (!$setting) {
            $setting = OwnerSetting::create([
                'owner_id' => $request->user()->id,
            ]);
        }

        $setting->update([
            'store_name' => $request->store_name,
            'store_description' => $request->store_description,
            'brand_color' => $request->brand_color ?: '#f97316',
            'social_links' => $request->social_links ? json_encode($request->social_links) : null,
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->back()->with('success', 'Store settings saved successfully.');
    }

    public function generateStoreUrl(Request $request)
    {
        $user = $request->user();

        if (!$user->store_uuid) {
            $user->store_uuid = (string) Str::uuid();
            $user->save();
        }

        $storeUrl = route('storefront.show', $user->store_uuid);

        return response()->json(['store_url' => $storeUrl]);
    }
}
