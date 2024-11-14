<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::query()->where('email', 'admin@admin.com')->first();

        if(!$admin) {
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => 'password',
            ]);
        }
    }
}
