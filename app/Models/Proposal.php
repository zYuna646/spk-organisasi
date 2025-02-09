<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;
    protected $fillable = [
        'organisasi_id',
        // 'periode_pengajuan_id',
        'nama_kegiatan',
        'deskripsi_kegiatan',
        'tanggal_pelaksanaan',
        'tanggal_pengajuan',
        'skala_kegiatan',
        'kebutuhan_dana',
        'nomor_rekening',
        'nama_rekening',
        'nama_bank',
        'link_drive',
        'status',
        'status_pengajuan',
        'pesan_pengajuan',
        'relevansi'

    ];

    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class);
    }

}
