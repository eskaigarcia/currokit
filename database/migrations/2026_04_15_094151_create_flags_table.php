<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_edit_id')->constrained()->cascadeOnDelete();
            $table->string('reason')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'company_edit_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flags');
    }
};
