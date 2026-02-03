<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User - untuk autentikasi & data user (admin/petugas/peminjam)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Kolom yang bisa diisi mass assignment
    protected $fillable = [
        'name',
        'nomor_identitas',
        'password',
        'role'
    ];

    // Kolom yang disembunyikan saat serialisasi (JSON)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast otomatis tipe data
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
