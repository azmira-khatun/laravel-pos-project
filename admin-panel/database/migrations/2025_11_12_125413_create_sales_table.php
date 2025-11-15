<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id(); // id BIGINT UNSIGNED [pk, increment]

            // Foreign Keys - Note the corrected data types
            $table->unsignedBigInteger('productunit_id');

            // 🔑 FIX 1: payment_method_id MUST be BigInteger to match payment_methods.id
            $table->unsignedBigInteger('payment_method_id');

            // Potential FIX 2: Assuming customers.id is BigInt/Int, I'm setting this to BigInt for consistency.
            // If your customers.id is a simple $table->id() or bigIncrements(), this is correct.
            $table->unsignedBigInteger('customer_id');

            // FIX 3: Removed ->unique(). A product can be sold many times.
            $table->unsignedBigInteger('product_id');

            // Other Columns
            $table->string('payment_status', 20);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->dateTime('sell_date');

            $table->timestamps(); // created_at and updated_at

            // Foreign key constraints
            $table->foreign('productunit_id')->references('id')->on('product_units')->onDelete('cascade');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('restrict');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
