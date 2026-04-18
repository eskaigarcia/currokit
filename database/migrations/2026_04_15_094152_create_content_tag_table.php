<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_tag', function (Blueprint $table) {
            $table->foreignId('platform_content_id')->constrained()->cascadeOnDelete();
            $table->foreignId('platform_tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['platform_content_id', 'platform_tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_tag');
    }
};
