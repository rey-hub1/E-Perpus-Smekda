<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    public const FINE_PER_DAY = 1000;
    public const LOAN_DAYS = 10;

    public static function loanDays(): int
    {
        return self::LOAN_DAYS;
    }

    protected $fillable = [
        'user_id', 'book_id', 'tanggal_pinjam', 'tanggal_ambil', 'due_date', 'tanggal_kembali', 'status', 'fine', 'return_code', 'pickup_code'
    ];

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    
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
            return $this->fine; 
        }

        $dendaEstimasi = $this->hari_telat * self::FINE_PER_DAY;
        return max($this->fine, $dendaEstimasi);
    }

    public function getIsTerlambatAttribute(): bool
    {
        return $this->status === 'dipinjam' && $this->due_date && \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($this->due_date));
    }

    public function getSisaHariAttribute(): ?int
    {
        if ($this->status === 'dipinjam' && !$this->is_terlambat && $this->due_date) {
            return (int) \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($this->due_date)->startOfDay(), false);
        }
        return null;
    }

    public function getAccentColorAttribute(): string
    {
        return match($this->status) {
            'menunggu_pengambilan' => 'bg-blue-500',
            'mengembalikan'        => 'bg-amber-400',
            'dipinjam'             => $this->is_terlambat ? 'bg-secondary' : 'bg-primary',
            'kembali'              => 'bg-accent',
            default                => 'bg-text/20',
        };
    }
}
