<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();  // id BIGINT UNSIGNED [pk, increment]

            // Foreign keys
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('payment_method_id');

            $table->unsignedBigInteger('product_id');

            // Data columns
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('line_discount', 10, 2)->default(0);
            $table->decimal('line_total', 10, 2);

            $table->timestamps(); // created_at + updated_at

            // Foreign key constraints
            $table->foreign('purchase_id')
                  ->references('id')->on('purchases')
                  ->onDelete('cascade');




            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('purchase_items');
    }
}
