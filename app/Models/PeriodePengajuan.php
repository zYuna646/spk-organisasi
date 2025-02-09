<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PeriodePengajuan extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'periode_mulai'];
    protected static function booted()
    {
        static::creating(function ($role) {
            if (!$role->slug) {
                $role->slug = Str::slug($role->name);
            }
        });
    }

}
