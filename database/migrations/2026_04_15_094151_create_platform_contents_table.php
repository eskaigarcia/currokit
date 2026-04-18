<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('platform_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sponsor_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('author');
            $table->text('excerpt')->nullable();
            $table->string('type');
            $table->string('topic')->nullable();
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            $table->boolean('visible')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platform_contents');
    }
};
