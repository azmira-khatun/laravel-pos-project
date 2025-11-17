<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMovementsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();

            // Foreign keys must match parent table type
            $table->unsignedBigInteger('product_id');

            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->unsignedBigInteger('purchase_return_id')->nullable(); // exists
            $table->unsignedBigInteger('damage_id')->nullable();

            $table->enum('movement_type', ['IN', 'OUT']);
            $table->integer('quantity');

            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamp('movement_date')->useCurrent();
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');

            $table->foreign('purchase_id')
                ->references('id')->on('purchases')
                ->onDelete('set null');

            $table->foreign('sale_id')
                ->references('id')->on('sales')
                ->onDelete('set null');

            $table->foreign('purchase_return_id')
                ->references('id')->on('purchase_returns')
                ->onDelete('set null');

            $table->foreign('damage_id')
                ->references('id')->on('damage_products')
                ->onDelete('set null');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('stock_movements');
    }
}
