<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Role: super_admin or owner
            $table->enum('role', ['super_admin', 'owner'])->default('owner')->after('email');
            
            // Bank information
            $table->string('bank_name')->nullable()->after('role');
            $table->string('bank_account_number')->nullable()->after('bank_name');
            $table->string('bank_account_name')->nullable()->after('bank_account_number');
            
            // Storefront identification
            $table->uuid('store_uuid')->nullable()->unique()->after('role');
            
            // Store customization
            $table->string('app_name')->default('SnapPhoto')->after('store_uuid');
            
            // Subscription management
            $table->boolean('subscription_active')->default(true)->after('app_name');
            $table->date('subscription_expires_at')->nullable()->after('subscription_active');
            $table->boolean('has_storefront')->default(false)->after('subscription_expires_at');
            $table->string('subscription_status')->default('active')->after('has_storefront');
            $table->date('subscription_valid_until')->nullable()->after('subscription_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'bank_account_number', 'bank_account_name', 'store_uuid', 'app_name', 'subscription_active', 'subscription_expires_at', 'has_storefront', 'subscription_status', 'subscription_valid_until']);
        });
    }
};
