<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Kategori - menyimpan kategori buku
 */
class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name'];

    // Relasi: Category hasMany Books (1 kategori punya banyak buku)
    public function books()
    {
        return $this->hasMany(Book::class, 'category_id');
    }
}
