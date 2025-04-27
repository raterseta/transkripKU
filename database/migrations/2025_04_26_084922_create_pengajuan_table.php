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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->string('custom_id')->unique();
            $table->string('jenis_pengajuan')
                ->default('Akademik');
            $table->string('nama');
            $table->string('nim');
            $table->string('email');
            $table->string('keperluan');
            $table->string('bahasa');
            $table->string('ttd');
            $table->string('catatan_tambahan')
                ->nullable();
            $table->string('file_pendukung')
                ->nullable();
            $table->string('status')
                ->default('Baru');
            $table->string('file_transkrip')
                ->nullable();
            $table->string('notes')
                ->nullable();
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
