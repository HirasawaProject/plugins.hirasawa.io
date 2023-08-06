<?php

namespace Database\Seeders\Production;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()->create([
            'name' => 'Administrator',
        ]);

        Role::factory()->create([
            'name' => 'Moderator',
        ]);

        Role::factory()->create([
            'name' => 'Plugin Developer',
        ]);

        
        Role::factory()->create([
            'name' => 'Hirasawa Developer',
        ]);

        Role::factory()->create([
            'name' => 'User',
        ]);
    }
}
