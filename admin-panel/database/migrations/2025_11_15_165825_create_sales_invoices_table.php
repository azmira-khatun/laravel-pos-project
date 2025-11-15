<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('sales_invoices', function (Blueprint $table) {
            $table->id(); // id INT auto increment primary key
            $table->string('invoice_number', 100)->unique();
            $table->unsignedBigInteger('sale_id')->unique();
            $table->unsignedBigInteger('customer_id');
            $table->dateTime('invoice_date');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('due_amount', 10, 2)->default(0);
            $table->string('payment_status', 50);
            $table->timestamps(); // created_at এবং updated_at

            // foreign keys (যদি sales এবং customers table থাকে)
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales_invoices');
    }
}
