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
$table->unsignedBigInteger('sale_id');
$table->unsignedBigInteger('product_id');
$table->unsignedBigInteger('productunit_id');
$table->integer('quantity');
$table->decimal('unit_price', 10, 2);
$table->decimal('discount_amount', 10, 2)->default(0);
$table->decimal('line_total', 12, 2);
$table->timestamps();


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
