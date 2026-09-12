<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\OwnerPaymentMethod;
use App\Models\OwnerSetting;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── Super Admin ──────────────────────────────────────────
        User::create([
            'name'              => 'Super Admin',
            'email'             => 'admin@sellflow.id',
            'password'          => Hash::make('password'),
            'role'              => 'super_admin',
            'email_verified_at' => now(),
        ]);

        // ── Owner Demo ───────────────────────────────────────────
        $owner = User::create([
            'name'                    => 'Demo Owner',
            'email'                   => 'owner@demo.com',
            'password'                => Hash::make('password'),
            'role'                    => 'owner',
            'email_verified_at'       => now(),
            'subscription_status'     => 'active',
            'subscription_valid_until'=> now()->addYear(),
            'subscription_active'     => true,
            'has_storefront'          => true,
            'store_uuid'              => (string) Str::uuid(),
        ]);

        // ── Owner Payment Methods ────────────────────────────────
        OwnerPaymentMethod::create([
            'owner_id'       => $owner->id,
            'bank_name'      => 'BCA',
            'account_number' => '1234567890',
            'account_name'   => 'Demo Owner',
            'type'           => 'bank',
            'is_default'     => true,
            'is_active'      => true,
        ]);

        OwnerPaymentMethod::create([
            'owner_id'       => $owner->id,
            'bank_name'      => 'Mandiri',
            'account_number' => '0987654321',
            'account_name'   => 'Demo Owner',
            'type'           => 'bank',
            'is_default'     => false,
            'is_active'      => true,
        ]);

        OwnerPaymentMethod::create([
            'owner_id'       => $owner->id,
            'bank_name'      => 'GoPay',
            'account_number' => '081234567890',
            'account_name'   => 'Demo Owner',
            'type'           => 'gopay',
            'is_default'     => false,
            'is_active'      => true,
        ]);

        // ── Owner Setting ────────────────────────────────────────
        OwnerSetting::create([
            'owner_id'          => $owner->id,
            'store_name'        => 'Demo Store',
            'store_description' => 'Toko demo untuk testing platform Sellflow.',
            'brand_color'       => '#f97316',
            'is_published'      => true,
        ]);

        // ── Categories ───────────────────────────────────────────
        $cats = collect(['Paket A', 'Paket B', 'Paket C', 'Paket D'])
            ->map(fn ($name) => Category::create(['owner_id' => $owner->id, 'name' => $name]));

        // ── Products ─────────────────────────────────────────────
        $products = [
            ['category_id' => $cats[0]->id, 'name' => 'Layanan Basic',   'description' => 'Paket layanan basic dengan fitur standar.',       'price' => 150000],
            ['category_id' => $cats[0]->id, 'name' => 'Layanan Standard','description' => 'Paket layanan standard dengan fitur lengkap.',     'price' => 350000],
            ['category_id' => $cats[1]->id, 'name' => 'Paket Premium',   'description' => 'Paket premium dengan semua fitur unggulan.',       'price' => 750000],
            ['category_id' => $cats[2]->id, 'name' => 'Paket Eksklusif', 'description' => 'Paket eksklusif untuk kebutuhan profesional.',     'price' => 1500000],
            ['category_id' => $cats[3]->id, 'name' => 'Add-on Spesial',  'description' => 'Tambahan layanan spesial sesuai kebutuhan.',       'price' => 200000],
        ];

        foreach ($products as $prod) {
            Product::create(array_merge(['owner_id' => $owner->id, 'is_active' => true], $prod));
        }
    }
}
