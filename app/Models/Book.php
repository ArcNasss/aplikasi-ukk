<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Buku - menyimpan data buku perpustakaan
 */
class Book extends Model
{
    // Kolom yang bisa diisi mass assignment (sesuai migration)
    protected $fillable = [
        'category_id',
        'judul',
        'synopsis',
        'foto',
        'penulis',
        'penerbit',
        'tahun'
    ];

    // Relasi: Buku belongsTo Category (1 buku punya 1 kategori)
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
