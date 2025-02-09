<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',    // Judul Berita
        'cover',    // Gambar cover berita
        'content',  // Isi berita
    ];

    /**
     * Menyimpan cover image (jika ada) dan memperbarui kolom cover.
     *
     * @param $request
     * @return string|null
     */
    public static function storeCover($request)
    {
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover')->store('public/berita_covers');
            return Storage::url($cover);  // Mengembalikan URL gambar yang disimpan
        }

        return null;  // Jika tidak ada cover image
    }
}
