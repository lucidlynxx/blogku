<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'name' => 'View Posts',
        ]);
        Permission::create([
            'name' => 'Create Posts',
        ]);
        Permission::create([
            'name' => 'Update Posts',
        ]);
        Permission::create([
            'name' => 'Delete Posts',
        ]);
    }
}
