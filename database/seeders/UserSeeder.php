<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => '$2y$10$Me2wc750j5VWstZb8VLmLOUgvVVJgWPkDNuL1as7Z/.QBezMsBu3m',
        ]);
    }
}
