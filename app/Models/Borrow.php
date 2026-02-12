<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $table = 'borrows';
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function petugas(){
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function bookItem(){
        return $this->belongsTo(BookItem::class, 'book_item_id');
    }

    public function returnBook(){
        return $this->hasOne(ReturnBook::class, 'borrows_id');
    }
}


