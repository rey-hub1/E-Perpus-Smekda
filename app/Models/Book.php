<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{

    protected $fillable = [
        'judul', 'penulis', 'penerbit',
        'tahun_terbit', 'stok', 'deskripsi', 'gambar'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
