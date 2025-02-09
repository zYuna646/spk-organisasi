<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisasi_id')->constrained()->onDelete('cascade');
            // $table->foreignId('periode_pengajuan_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_pengajuan')->default(Date::now());
            $table->string('nama_kegiatan');
            $table->text('deskripsi_kegiatan');
            $table->date('tanggal_pelaksanaan');
            $table->boolean('status')->default(false);
            $table->enum('status_pengajuan', ['periksa', 'terima', 'tolak'])->default('periksa');
            $table->string('pesan_pengajuan')->nullable();
            $table->enum('skala_kegiatan', ['nasional', 'provinsi', 'daerah']);
            $table->enum('relevansi', ['Sangat Sesuai', 'Sesuai', 'Tidak Sesuai', 'Sangat  Tidak Sesuai'])->nullable();
            $table->string('surat_undangan')->nullable(); // Assuming surat_undangan is a file path or URL
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};
