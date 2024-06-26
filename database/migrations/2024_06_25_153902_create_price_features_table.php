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
        Schema::create('price_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('price_id')->constrained('prices')->onDelete('cascade');
            $table->json('icon')->nullable();
            $table->string('text');
            $table->string('change')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_features');
    }
};
