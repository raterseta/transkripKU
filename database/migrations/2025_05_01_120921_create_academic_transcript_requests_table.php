<?php

use App\Enums\RequestStatus;
use App\Enums\SignatureType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_transcript_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tracking_number');
            $table->enum('status', array_column(RequestStatus::cases(), 'value'))
                ->default(RequestStatus::PROSESOPERATOR->value);
            $table->string('student_nim');
            $table->string('student_name');
            $table->string('student_email');
            $table->string('needs');
            $table->string('language');
            $table->enum('signature_type', array_column(SignatureType::cases(), 'value'));
            $table->string('transcript_url')->nullable();
            $table->string('retrieval_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_transcript_requests');
    }
};
