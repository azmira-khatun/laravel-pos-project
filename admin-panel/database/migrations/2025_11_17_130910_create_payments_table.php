<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('sale_id')->nullable();
            $table->unsignedBigInteger('purchase_id')->nullable();

            $table->unsignedBigInteger('payment_method_id');
            $table->decimal('amount', 10, 2);
            $table->dateTime('payment_date')->default(now());

            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamp('created_at')->useCurrent();

            // Foreign Keys
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('set null');
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('set null');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
