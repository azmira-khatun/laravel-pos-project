<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profit_records', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('sale_item_id')->unique(); // FK to sales_items
            $table->unsignedBigInteger('product_id'); // FK to products

            $table->decimal('cost_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->decimal('profit_amount', 10, 2);

            $table->date('record_date')->default(DB::raw('CURRENT_DATE'));

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('sale_item_id')
                  ->references('id')->on('sales_items')
                  ->onDelete('cascade');

            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profit_records');
    }
};
