<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            $table->string('address')->nullable();
            $table->string('cover')->nullable();
            $table->integer('list')->nullable();
            $table->json('icon')->nullable();
            $table->timestamps();
        });
    }
   public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
