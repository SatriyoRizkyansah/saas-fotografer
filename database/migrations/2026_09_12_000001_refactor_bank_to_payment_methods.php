<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Pastikan payment_method_id ada & punya foreign key yang benar
        Schema::table('transactions', function (Blueprint $table) {
            // Kolom sudah ada dari migration 072217 — cukup pastikan FK-nya ada
            // Kalau belum ada kolom, buat sekaligus
            if (!Schema::hasColumn('transactions', 'payment_method_id')) {
                $table->foreignId('payment_method_id')
                      ->nullable()
                      ->after('product_id')
                      ->constrained('owner_payment_methods')
                      ->nullOnDelete();
            } else {
                // Kolom sudah ada, pastikan FK constraint terpasang
                // Drop dulu kalau ada FK lama, lalu re-create dengan benar
                try {
                    $table->dropForeign(['payment_method_id']);
                } catch (\Throwable) {
                    // FK belum ada — tidak apa-apa
                }
                $table->foreign('payment_method_id')
                      ->references('id')
                      ->on('owner_payment_methods')
                      ->nullOnDelete();
            }
        });

        // 2. Drop kolom bank dari users kalau masih ada
        Schema::table('users', function (Blueprint $table) {
            $cols     = ['bank_name', 'bank_account_number', 'bank_account_name'];
            $existing = array_values(array_filter($cols, fn ($c) => Schema::hasColumn('users', $c)));
            if (!empty($existing)) {
                $table->dropColumn($existing);
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            try { $table->dropForeign(['payment_method_id']); } catch (\Throwable) {}
            if (Schema::hasColumn('transactions', 'payment_method_id')) {
                $table->dropColumn('payment_method_id');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'bank_name')) {
                $table->string('bank_name')->nullable()->after('role');
                $table->string('bank_account_number')->nullable()->after('bank_name');
                $table->string('bank_account_name')->nullable()->after('bank_account_number');
            }
        });
    }
};
