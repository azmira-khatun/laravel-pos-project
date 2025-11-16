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
    Schema::table('sales_items', function (Blueprint $table) {
        $table->decimal('tax_amount', 10, 2)->default(0);
        $table->string('batch_no')->nullable();
        $table->date('expiry_date')->nullable();
        $table->text('description')->nullable();
        $table->decimal('total_cost', 10, 2)->default(0);
        $table->string('status')->default('pending');
    });
}

public function down(): void
{
    Schema::table('sales_items', function (Blueprint $table) {
        $table->dropColumn(['tax_amount','batch_no','expiry_date','description','total_cost','status']);
    });
}

};
