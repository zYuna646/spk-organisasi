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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisasi_id')->constrained()->onDelete('cascade');
            $table->string('nama_kegiatan');
            $table->date('tanggal_pelaksanaan');
            $table->string('tempat_kegiatan');
            $table->string('tujuan_kegiatan');
            $table->string('laporan_kegiatan')->nullable(); // Untuk menyimpan file laporan kegiatan
            $table->enum('status_pengajuan', ['periksa', 'terima', 'tolak'])->default('periksa');
            $table->string('pesan_pengajuan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
