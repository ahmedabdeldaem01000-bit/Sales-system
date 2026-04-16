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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->cascadeOnDelete()
                ->comment('Reference to order (for direct payments)');
            $table->foreignId('installment_item_id')
                ->nullable()
                ->constrained('installment_items')
                ->cascadeOnDelete()
                ->comment('Reference to installment item (for installment payments)');
            $table->decimal('amount', 10, 2)->comment('Payment amount');
            $table->enum('method', ['cash', 'paypal'])->default('cash')->comment('Payment method');
            $table->date('payment_date')->comment('Date of payment');
            $table->timestamps();

            $table->index('order_id');
            $table->index('installment_item_id');
            $table->index('payment_date');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
