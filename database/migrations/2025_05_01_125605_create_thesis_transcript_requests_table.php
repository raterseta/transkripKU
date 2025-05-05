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
        Schema::create('thesis_transcript_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tracking_number');
            $table->enum('status', array_column(RequestStatus::cases(), 'value'))
                ->default(RequestStatus::PROSESOPERATOR->value);
            $table->string('student_nim');
            $table->string('student_name');
            $table->string('student_email');
            $table->string('student_notes')->nullable();
            $table->string('transcript_url')->nullable();
            $table->string('supporting_document_url')->nullable();
            $table->string('consultation_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thesis_transcript_requests');
    }
};
