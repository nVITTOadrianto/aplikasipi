<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::factory()->create([
            'name' => 'bidang_pi',
            'email' => 'pemberdayaanindustri20@gmail.com',
            'password' => '$2y$10$U1jFZf8tVCrBb/DBRVxa0utGXFT9fNBFst/elA.7vdHYVRmbDeoPq',
        ]);
    }
}
