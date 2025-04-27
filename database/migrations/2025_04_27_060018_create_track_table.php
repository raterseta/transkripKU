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
        Schema::create('track', function (Blueprint $table) {
            $table->id();
            $table->string('custom_id');
            $table->string('nama');
            $table->string('nim');
            $table->string('status');
            // $table->timestamp('updated_at');
            $table->string('sumber'); // pengajuan atau pengajuan_final
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track');
    }
};
