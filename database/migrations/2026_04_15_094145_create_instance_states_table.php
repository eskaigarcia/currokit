<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instance_states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instance_id')->constrained('company_instances')->cascadeOnDelete();
            $table->string('state');
            $table->timestamp('set_at')->useCurrent();
            $table->timestamp('unset_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instance_states');
    }
};
