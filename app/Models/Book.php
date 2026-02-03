<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Buku - menyimpan data buku perpustakaan
 */
class Book extends Model
{
    protected $fillable = ['title', 'stock', 'category_id'];

    // Relasi: Buku belongsTo Category (1 buku punya 1 kategori)
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
