<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{

    protected $fillable = [
        'judul',
        'slug',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'stok',
        'deskripsi',
        'gambar',
        'favorite',
        'read_count',
        'featured'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
