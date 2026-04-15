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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('prg', 10, 2)->default(0);
            $table->string('phone')->nullable();
            $table->string('role')->default('employee');
            $table->string('email')->nullable();
            $table->string('password')->default('employee');
            $table->unsignedBigInteger('supplier_id')->default(1)->constrained('suppliers')->onDelete('set null');
            $table->unsignedBigInteger('employee_id')->default(1)->constrained('employees')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
