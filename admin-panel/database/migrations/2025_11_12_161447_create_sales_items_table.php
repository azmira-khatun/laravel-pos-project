<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sales_items', function (Blueprint $table) {
            $table->id(); // id INT [pk, increment]

            $table->unsignedBigInteger('sale_id');             // sale_id INT [not null, ref: > sales.id]
            $table->unsignedBigInteger('product_id');          // product_id BIGINT [not null, ref: > products.id]
            $table->unsignedBigInteger('productunit_id');      // productunit_id BIGINT [not null, ref: > product_units.id]
            $table->integer('quantity');                        // quantity INT [not null]
            $table->decimal('unit_price', 10, 2);               // unit_price DECIMAL(10,2) [not null]
            $table->unsignedBigInteger('discount_id')->nullable();   // discount_id INT [ref: > discounts.id]
            $table->decimal('discount_amount', 10, 2)->default(0);   // discount_amount DECIMAL(10,2) [default: 0]
            $table->decimal('line_total', 10, 2);               // line_total DECIMAL(10,2) [not null]
            $table->timestamps(); // created_at & updated_at (default now)

            // Foreign keys
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
            $table->foreign('productunit_id')->references('id')->on('product_units')->onDelete('restrict');
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('sales_items');
    }
}
