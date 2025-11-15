<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 150);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->unsignedBigInteger('productunit_id');
            $table->string('barcode', 100)->unique()->nullable();
            $table->text('description')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Foreign keys
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('productunit_id')->references('id')->on('product_units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
public function down(): void
    {
        // 1. Rollback সফল করার জন্য নির্ভরশীল টেবিলের সমস্যা এড়াতে এটি ব্যবহার করুন
        Schema::disableForeignKeyConstraints();

        Schema::table('products', function (Blueprint $table) {
            // 2. প্রতিটি ফরেন কী ড্রপ করার চেষ্টা করুন।
            // যদি কী না থাকে (ত্রুটি 1091), তবে তা উপেক্ষা করা হবে।
            $foreignKeys = ['category_id', 'sub_category_id', 'productunit_id'];

            foreach ($foreignKeys as $key) {
                try {
                    $table->dropForeign([$key]);
                } catch (\Exception $e) {
                    // Foreign key does not exist, ignore the error (ত্রুটি উপেক্ষা করুন)
                }
            }
        });

        // 3. টেবিলটি ড্রপ করুন
        Schema::dropIfExists('products');

        // 4. কাজ শেষে আবার ফরেন কী চেক চালু করুন
        Schema::enableForeignKeyConstraints();
    }
};
