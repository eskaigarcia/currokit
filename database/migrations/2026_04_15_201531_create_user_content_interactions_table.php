<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_content_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('platform_content_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['liked', 'saved']);
            $table->timestamps();
            $table->unique(['user_id', 'platform_content_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_content_interactions');
    }
};
