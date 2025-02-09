<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'ketua_umum',
        'tahun_berdiri',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
