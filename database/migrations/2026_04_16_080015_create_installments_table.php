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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete()
                ->comment('Reference to the order');
            $table->foreignId('plan_id')
                ->nullable()
                ->constrained('installment_plans')
                ->cascadeOnDelete()
                ->comment('Reference to the installment plan');
            $table->decimal('total_with_interest', 10, 2)->comment('Total amount including interest');
            $table->decimal('down_payment', 10, 2)->default(0)->comment('Initial down payment');
            $table->decimal('remaining_amount', 10, 2)->comment('Remaining amount to be paid');
            $table->date('start_date')->comment('Date when installment starts');
            $table->timestamps();

            $table->index('order_id');
            $table->index('plan_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
