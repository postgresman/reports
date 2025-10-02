<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('log_service_titan_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('market_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('service_titan_job_id');
            $table->unsignedBigInteger('business_unit_id')->nullable();
            $table->unsignedBigInteger('job_type_id')->nullable();
            $table->json('tag_type_ids')->nullable();
            $table->unsignedBigInteger('technician_id')->nullable();
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->timestamp('arrival_window_start')->nullable();
            $table->timestamp('arrival_window_end')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('summary')->nullable();
            $table->json('chargebee')->nullable();
            $table->json('web_session_data')->nullable();
            $table->json('attributions_sent')->nullable();
            $table->string('job_status')->nullable();
            $table->string('s2f')->nullable();
            $table->unsignedBigInteger('referral_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['market_id', 'service_titan_job_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('log_service_titan_jobs');
    }
};