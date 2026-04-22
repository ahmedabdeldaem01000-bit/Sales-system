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
        Schema::create('installment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installment_id')
                ->constrained('installments')
                ->cascadeOnDelete()
                ->comment('Reference to the installment');
            $table->date('due_date')->comment('Due date for this installment item');
            $table->decimal('amount', 10, 2)->comment('Amount due');
            $table->decimal('paid_amount', 10, 2)->default(0)->comment('Amount already paid');
            $table->enum('status', ['pending', 'paid', 'late'])->default('pending')->comment('Payment status');
            $table->timestamps();
            $table->string('payment_link')->nullable();
            $table->string('paypal_order_id')->nullable();


            $table->string('paypal_token')->nullable()->index();
            $table->index('installment_id');
            $table->index('due_date');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installment_items');
    }
};
