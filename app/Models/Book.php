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

    // Relasi: Buku hasMany BookItem (1 buku bisa punya banyak item fisik)
    public function bookItems() {
        return $this->hasMany(BookItem::class);
    }

    // Accessor: Generate URL foto
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return 'https://via.placeholder.com/60x80?text=No+Cover';
    }

    // Accessor: Hitung stock available
    public function getStockAttribute()
    {
        return $this->bookItems()->where('status', 'available')->count();
    }
}
