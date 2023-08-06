<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Plugin;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->withRoles([
            Role::where('name', 'Administrator')->first(),
        ])->create([
            'name' => 'admin',
            'email' => 'admin@hirasawa.io',
            'password' => Hash::make('admin'),
        ]);

        User::factory(100)->create();
        Plugin::factory(10)->withReleases(5)->withComments(100)->giveAuthorRole()->create();
    }
}
