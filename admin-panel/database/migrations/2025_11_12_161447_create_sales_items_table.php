<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesItemsTable extends Migration
{
    public function up()
    {
        Schema::create('sales_items', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('productunit_id');

            // Main Fields
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);

            // Discount fields
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0);

            // Tax
            $table->decimal('tax_amount', 10, 2)->default(0);

            // Batch and expiry
            $table->string('batch_no')->nullable();
            $table->date('expiry_date')->nullable();

            // Extra fields
            $table->text('description')->nullable();

            // Totals
            $table->decimal('line_total', 12, 2)->default(0);
            $table->decimal('total_cost', 12, 2)->default(0);

            // Status field
            $table->string('status')->default('active');

            $table->timestamps();

            // Foreign Keys
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('productunit_id')->references('id')->on('product_units')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales_items');
    }
}
