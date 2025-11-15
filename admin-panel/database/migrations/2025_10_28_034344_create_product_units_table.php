<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_units', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary key (auto increment)
            $table->string('unit_name', 100); // যেমন: kg, liter, piece
            $table->text('description')->nullable(); // optional field
            $table->timestamps(); // created_at এবং updated_at স্বয়ংক্রিয়ভাবে যুক্ত হবে
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_units');
    }
};
