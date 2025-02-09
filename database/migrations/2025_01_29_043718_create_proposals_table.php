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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisasi_id')->constrained(); // Jika ada relasi ke tabel organisasi
            // $table->foreignId('periode_pengajuan_id')->constrained(); // Jika ada relasi ke tabel organisasi
            $table->string('nama_kegiatan');
            $table->text('deskripsi_kegiatan');
            $table->date('tanggal_pelaksanaan');
            $table->date('tanggal_pengajuan')->default(Date::now());
            $table->enum('skala_kegiatan', ['nasional', 'provinsi', 'daerah']);
            $table->decimal('kebutuhan_dana', 15, 2);
            $table->string('nomor_rekening');
            $table->string('nama_rekening');
            $table->string('nama_bank');
            $table->enum('relevansi', ['Sangat Sesuai', 'Sesuai', 'Tidak Sesuai', 'Sangat  Tidak Sesuai'])->nullable();

            $table->boolean('status')->default(false);
            $table->enum('status_pengajuan', ['periksa', 'terima', 'tolak'])->default('periksa');
            $table->string('pesan_pengajuan')->nullable();
            $table->string('link_drive')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
