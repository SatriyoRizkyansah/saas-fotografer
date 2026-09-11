<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Owner/Photographer account
        $owner = User::create([
            'name' => 'Fotografer Demo',
            'email' => 'fotografer@demo.com',
            'password' => Hash::make('password'),
            'bank_name' => 'Bank BCA',
            'bank_account_number' => '1234567890',
            'bank_account_name' => 'Fotografer Demo',
            'role' => 'owner',
            'email_verified_at' => now(),
            'subscription_status' => 'active',
            'subscription_valid_until' => now()->addYear(),
            'has_storefront' => true,
            'subscription_active' => true,
        ]);

        // Create Super Admin account
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@snapphoto.id',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'email_verified_at' => now(),
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Pernikahan'],
            ['name' => 'Prewedding'],
            ['name' => 'Portrait'],
            ['name' => 'Event'],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[] = Category::create([
                'owner_id' => $owner->id,
                'name' => $cat['name'],
            ]);
        }

        // Create Products
        $products = [
            [
                'category_id' => $createdCategories[0]->id,
                'name' => 'Paket Pernikahan Basic',
                'description' => 'Paket foto pernikahan basic dengan durasi 4 jam, 200 editan foto, dan 1 album.',
                'price' => 5000000,
            ],
            [
                'category_id' => $createdCategories[0]->id,
                'name' => 'Paket Pernikahan Premium',
                'description' => 'Paket foto pernikahan premium dengan durasi 8 jam, 500 editan foto, 2 album, dan video highlight.',
                'price' => 15000000,
            ],
            [
                'category_id' => $createdCategories[1]->id,
                'name' => 'Paket Prewedding Outdoor',
                'description' => 'Sesi foto prewedding outdoor di 2 lokasi, 100 editan foto.',
                'price' => 3000000,
            ],
            [
                'category_id' => $createdCategories[2]->id,
                'name' => 'Sesi Foto Portrait',
                'description' => 'Sesi foto portrait studio, 20 editan foto high resolution.',
                'price' => 500000,
            ],
            [
                'category_id' => $createdCategories[3]->id,
                'name' => 'Paket Event Half Day',
                'description' => 'Dokumentasi event selama 4 jam, 200 editan foto.',
                'price' => 2000000,
            ],
        ];

        foreach ($products as $prod) {
            Product::create(array_merge([
                'owner_id' => $owner->id,
            ], $prod));
        }
    }
}
