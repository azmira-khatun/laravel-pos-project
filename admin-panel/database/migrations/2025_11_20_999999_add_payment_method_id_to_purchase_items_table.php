<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {

            if (!Schema::hasColumn('purchase_items', 'payment_method_id')) {
                // সবচেয়ে নিরাপদ পদ্ধতি: foreignId() helper ব্যবহার করা
                $table->foreignId('payment_method_id')
                      ->nullable()
                      ->constrained('payment_methods') // এটি references('id')->on('payment_methods') এর কাজ করে
                      ->onDelete('set null')
                      ->after('purchase_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            // Foreign key drop করা
            $table->dropForeign(['payment_method_id']);

            // কলাম drop করা
            $table->dropColumn('payment_method_id');
        });
    }
};
