<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateSalesTable extends Migration
{
public function up()
{
Schema::create('sales', function (Blueprint $table) {
$table->id();
$table->unsignedBigInteger('customer_id');
$table->unsignedBigInteger('payment_method_id');


$table->decimal('subtotal_amount', 12, 2)->default(0);
$table->decimal('discount_amount', 12, 2)->default(0);
$table->decimal('tax_amount', 12, 2)->default(0);
$table->decimal('shipping_cost', 12, 2)->default(0);
$table->decimal('total_cost', 12, 2)->default(0);


$table->decimal('paid_amount', 12, 2)->default(0);
$table->decimal('due_amount', 12, 2)->default(0);
$table->string('payment_status', 20);
$table->dateTime('sell_date')->nullable();


$table->timestamps();


$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
$table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('restrict');
});
}


public function down()
{
Schema::dropIfExists('sales');
}
}
