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
        Schema::create('calculation_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->default(1); // Default ke user 1 untuk sementara
            $table->string('sport_name');
            $table->integer('duration_minutes');
            $table->float('weight_kg');
            $table->float('calories_burned');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculation_histories');
    }
};
