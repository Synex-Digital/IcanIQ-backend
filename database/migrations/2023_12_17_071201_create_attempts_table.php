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
        Schema::create('attempts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('model_id');
            $table->timestamp('start_quiz')->nullable();
            $table->timestamp('end_quiz')->nullable();
            $table->enum('status', ['pending', 'accept', 'reject']);
            $table->integer('admin_notification')->default(0);
            $table->integer('user_notification')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attempts');
    }
};
