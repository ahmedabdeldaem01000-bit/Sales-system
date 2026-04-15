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
       Schema::create('debt_logs', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('debt_id');
    $table->string('action'); // updated, deleted
    $table->json('old_data')->nullable();
    $table->json('new_data')->nullable();
    $table->unsignedBigInteger('performed_by')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debt_logs');
    }
};
