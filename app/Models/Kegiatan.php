<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'organisasi_id',
        // 'periode_pengajuan_id',
        'tanggal_pengajuan',
        'nama_kegiatan',
        'deskripsi_kegiatan',
        'tanggal_pelaksanaan',
        'skala_kegiatan',
        'surat_undangan',
        'status',
        'status_pengajuan',
        'pesan_pengajuan',
        'relevansi'
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime', // Cast to Carbon instance
        'tanggal_pelaksanaan' => 'datetime', // If needed, you can also cast 'tanggal_pelaksanaan'
    ];

    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class);
    }

    public function periodePengajuan()
    {
        return $this->belongsTo(PeriodePengajuan::class);
    }
}
