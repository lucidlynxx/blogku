<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('password123')
        ]);
        \App\Models\User::factory(3)->create();
        $this->call(CategorySeeder::class);
        $this->call(PostSeeder::class);
        $this->call(TextWidgetSeeder::class);
    }
}
