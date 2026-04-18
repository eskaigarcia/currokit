<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offer_states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained()->cascadeOnDelete();
            $table->string('state');
            $table->timestamp('set_at')->useCurrent();
            $table->timestamp('unset_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offer_states');
    }
};
