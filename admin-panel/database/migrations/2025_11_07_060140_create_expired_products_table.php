<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expired_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->date('expiry_date');

            // ত্রুটি সংশোধিত: user_id কলামে ->nullable() যোগ করা হয়েছে
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamp('noted_on')->useCurrent();

            // Foreign keys
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // এখন onDelete('set null') সঠিকভাবে কাজ করবে
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        // রোলব্যাক ত্রুটি এড়াতে dropForeign সহ full down() পদ্ধতিটি ব্যবহার করা ভালো।
        Schema::table('expired_products', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('expired_products');
    }
};
