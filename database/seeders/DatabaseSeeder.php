<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'admin',
            'nomor_identitas' => '1',
            'role' => 'admin',
            'password' => bcrypt('11111111'),
        ],
        [
            'name' => 'petugas',
            'nisn' => '11',
            'role' => 'petugas',
            'password' => bcrypt('11111111'),
        ],
        [
            'name' => 'peminjam',
            'nisn' => '111',
            'role' => 'peminjam',
            'password' => bcrypt('11111111'),
        ]);
    }
}
