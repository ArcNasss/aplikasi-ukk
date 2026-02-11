<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookItem extends Model
{
    protected $fillable = [
        'book_id',
        'kode_buku',
        'status'
    ];

    // Relasi: BookItem belongsTo Book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
