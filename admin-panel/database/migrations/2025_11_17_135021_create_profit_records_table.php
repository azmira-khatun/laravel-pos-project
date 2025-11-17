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
        Schema::create('profit_records', function (Blueprint $table) {
            $table->id();

            // FK to sales_items
            $table->unsignedBigInteger('sale_item_id')->unique();
            $table->foreign('sale_item_id')
                  ->references('id')->on('sales_items')
                  ->onDelete('cascade');

            // FK to products
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('cascade');

            $table->decimal('cost_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->decimal('profit_amount', 10, 2);

            $table->date('record_date')->default(DB::raw('CURRENT_DATE'));

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profit_records');
    }
};
