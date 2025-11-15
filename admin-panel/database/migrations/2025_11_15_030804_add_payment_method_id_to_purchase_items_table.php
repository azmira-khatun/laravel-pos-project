<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            // payment_method_id কলাম যোগ করা
            $table->unsignedBigInteger('payment_method_id')->nullable()->after('purchase_id');

            // foreign key constraint
            $table->foreign('payment_method_id')
                  ->references('id')
                  ->on('payment_methods')
                  ->onDelete('set null'); // অথবা cascade, যেভাবে চাও
        });
    }

    public function down(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            // foreign key drop করা
            $table->dropForeign(['payment_method_id']);

            // কলাম drop করা
            $table->dropColumn('payment_method_id');
        });
    }
};
