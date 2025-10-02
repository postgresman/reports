<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('log_service_titan_jobs', function (Blueprint $table) {
            $table->index('market_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_service_titan_jobs', function (Blueprint $table) {
            $table->dropIndex(['market_id']);
        });
    }
};
