<?php

use App\Enums\RequestStatus;
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
        Schema::create('request_tracks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tracking_number');
            $table->uuid('academic_transcript_request_id')->nullable();
            $table->uuid('thesis_transcript_request_id')->nullable();
            $table->string('action_notes');
            $table->string('action_desc');
            $table->enum('status', array_column(RequestStatus::cases(), 'value'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_tracks');
    }
};
