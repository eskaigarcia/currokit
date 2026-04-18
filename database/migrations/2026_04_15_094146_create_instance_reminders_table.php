<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instance_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instance_id')->constrained('company_instances')->cascadeOnDelete();
            $table->string('content');
            $table->string('type')->default('manual');
            $table->timestamp('reminding_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instance_reminders');
    }
};
