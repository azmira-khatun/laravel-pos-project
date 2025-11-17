<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedBigInteger('product_id');

            $table->unsignedInteger('purchase_id')->nullable();
            $table->unsignedInteger('sale_id')->nullable();
            $table->unsignedInteger('sale_return_id')->nullable();
            $table->unsignedBigInteger('purchase_return_id')->nullable();
            $table->unsignedInteger('damage_id')->nullable();

            $table->enum('movement_type', ['IN', 'OUT']);
            $table->integer('quantity');

            $table->unsignedInteger('user_id')->nullable();
            $table->timestamp('movement_date')->useCurrent();

            // Foreign Keys
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('set null');
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('set null');
            $table->foreign('sale_return_id')->references('id')->on('sale_returns')->onDelete('set null');
            $table->foreign('purchase_return_id')->references('id')->on('purchase_returns')->onDelete('set null');
            $table->foreign('damage_id')->references('id')->on('damage_products')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
