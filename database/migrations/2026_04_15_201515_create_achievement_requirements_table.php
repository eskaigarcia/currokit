<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievement_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('achievement_id')->constrained()->cascadeOnDelete();
            $table->string('condition_key');
            $table->string('operator')->default('>=');
            $table->integer('threshold');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievement_requirements');
    }
};
