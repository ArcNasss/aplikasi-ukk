<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnBook extends Model
{
    protected $fillable = [
        'borrows_id',
        'tanggal_pengembalian',
        'status',
        'denda',
    ];

    public function borrow()
    {
        return $this->belongsTo(Borrow::class, 'borrows_id');
    }
}
