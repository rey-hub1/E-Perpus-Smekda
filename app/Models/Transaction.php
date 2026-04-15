<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    public const FINE_PER_DAY = 1000;

    /**
     * Ambil jumlah hari peminjaman dari settings (default 10).
     */
    public static function loanDays(): int
    {
        return (int) Setting::get('loan_days', 10);
    }

    protected $fillable = [
        'user_id', 'book_id', 'tanggal_pinjam', 'tanggal_ambil', 'due_date', 'tanggal_kembali', 'status', 'fine', 'return_code', 'pickup_code'
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

    public function getHariTelatAttribute(): int
    {
        if (in_array($this->status, ['dipinjam', 'mengembalikan']) && $this->due_date) {
            $now = \Carbon\Carbon::now();
            $dueDate = \Carbon\Carbon::parse($this->due_date);
            if ($now->gt($dueDate)) {
                return (int) $now->startOfDay()->diffInDays($dueDate->startOfDay());
            }
        }
        return 0;
    }

    public function getDendaBerjalanAttribute(): int
    {
        if ($this->status === 'kembali') {
            return $this->fine; // Kembalikan denda yang sudah dicatat saat selesai
        }

        $dendaEstimasi = $this->hari_telat * self::FINE_PER_DAY;
        return max($this->fine, $dendaEstimasi);
    }
}
