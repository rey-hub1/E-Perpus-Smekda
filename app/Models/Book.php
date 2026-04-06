<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{

    protected $fillable = [
        'category_id',
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

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'book_user')->withTimestamps();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function libraryEntries(): HasMany
    {
        return $this->hasMany(UserLibrary::class);
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getCoverUrlAttribute()
    {
        if ($this->gambar) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->gambar)) {
                return asset('storage/' . $this->gambar);
            }
            if (file_exists(public_path('images/' . $this->gambar))) {
                return asset('images/' . $this->gambar);
            }
        }
        return null;
    }
}
