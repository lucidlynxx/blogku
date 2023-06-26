<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        Role::create(['name' => 'writer']);

        $adminUser = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('password123')
        ]);

        $adminUser->assignRole($adminRole);

        $this->call(PermissionSeeder::class);
        \App\Models\User::factory(3)->create();
        $this->call(CategorySeeder::class);
        $this->call(PostSeeder::class);
        $this->call(TextWidgetSeeder::class);
    }
}
