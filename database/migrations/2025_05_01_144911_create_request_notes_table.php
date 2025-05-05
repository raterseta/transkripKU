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
        Schema::create('request_notes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('academic_transcript_request_id');
            $table->uuid('thesis_transcript_request_id');
            $table->uuid('sender_id');
            $table->string('receiver_email');
            $table->string('transcript_url');
            $table->string('public_notes');
            $table->string('private_notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_notes');
    }
};
