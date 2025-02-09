<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'organisasi_id',
        'nama_kegiatan',
        'tanggal_pelaksanaan',
        'tempat_kegiatan',
        'tujuan_kegiatan',
        'laporan_kegiatan',
        'status_pengajuan',
        'pesan_pengajuan',

    ];

    /**
     * Relasi dengan Organisasi
     */
    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class);
    }

    /**
     * Menyimpan file yang diupload ke dalam folder storage dan menyimpan path-nya.
     */

}
