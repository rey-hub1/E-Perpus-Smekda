<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'book_id', 'tanggal_pinjam', 'due_date', 'tanggal_kembali', 'status', 'fine'
    ];

    // Relasi ke User (Siapa yang minjam?)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Book (Buku apa yang dipinjam?)
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
