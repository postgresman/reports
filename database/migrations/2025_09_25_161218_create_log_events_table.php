<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('log_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('market_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_name_id')->constrained('event_names')->cascadeOnDelete();
            $table->string('session_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['market_id', 'event_name_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('log_events');
    }
};