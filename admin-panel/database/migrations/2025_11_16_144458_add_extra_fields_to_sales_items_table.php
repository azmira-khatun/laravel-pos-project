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
        Schema::table('sales_items', function (Blueprint $table) {

            // tax_amount
            if (!Schema::hasColumn('sales_items', 'tax_amount')) {
                $table->decimal('tax_amount', 10, 2)->default(0);
            }

            // batch_no
            if (!Schema::hasColumn('sales_items', 'batch_no')) {
                $table->string('batch_no')->nullable();
            }

            // expiry_date
            if (!Schema::hasColumn('sales_items', 'expiry_date')) {
                $table->date('expiry_date')->nullable();
            }

            // description
            if (!Schema::hasColumn('sales_items', 'description')) {
                $table->text('description')->nullable();
            }

            // total_cost
            if (!Schema::hasColumn('sales_items', 'total_cost')) {
                $table->decimal('total_cost', 10, 2)->default(0);
            }

            // status
            if (!Schema::hasColumn('sales_items', 'status')) {
                $table->string('status')->default('pending');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_items', function (Blueprint $table) {
            // Drop columns only if they exist to prevent errors during rollback
            if (Schema::hasColumn('sales_items', 'tax_amount')) {
                $table->dropColumn('tax_amount');
            }
            if (Schema::hasColumn('sales_items', 'batch_no')) {
                $table->dropColumn('batch_no');
            }
            if (Schema::hasColumn('sales_items', 'expiry_date')) {
                $table->dropColumn('expiry_date');
            }
            if (Schema::hasColumn('sales_items', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('sales_items', 'total_cost')) {
                $table->dropColumn('total_cost');
            }
            if (Schema::hasColumn('sales_items', 'status')) {
                $table->dropColumn('status');
            }
            // Alternatively, you can attempt to drop all in one line if you are sure:
            // $table->dropColumn(['tax_amount', 'batch_no', 'expiry_date', 'description', 'total_cost', 'status']);
        });
    }
};
