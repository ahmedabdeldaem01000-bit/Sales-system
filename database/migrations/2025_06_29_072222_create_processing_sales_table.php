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
       Schema::create('processing_sales', function (Blueprint $table) {
        $table->id();
        $table->string('product_name');
        $table->integer('total_quantity_sold');
        $table->decimal('total_sales', 10, 2);
        $table->integer('current_stock');
        $table->integer('original_stock');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processing_sales');
    }
};
