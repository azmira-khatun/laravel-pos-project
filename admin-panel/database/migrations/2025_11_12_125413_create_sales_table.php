<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('productunit_id')->nullable();
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('product_id'); // NOT NULL
            $table->string('payment_status')->default('Due');
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->dateTime('sell_date')->default(now());
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
