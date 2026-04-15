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
        Schema::create('debtors', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم الجندي المدين
            $table->decimal('price', 10, 2); // إجمالي الدين
            $table->integer('quantity'); // عدد المنتجات اللي اتدينها
            $table->string('user'); // اسم المستخدم اللي سجل الدين
            $table->unsignedBigInteger('employee_id'); // الموظف المسؤول
            $table->date('date'); // تاريخ العملية
             $table->enum('payment_status', ['paid', 'unpaid'])->default('paid');
                  $table->string('customer_name')->nullable();
             
            $table->timestamps();
    
            // مفتاح خارجي للموظف
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debtors');
    }
};
