<?php

namespace Database\Seeders\Production;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->create([
            'name' => 'Administration',
            'slug' => 'administration',
        ]);

        Category::factory()->create([
            'name' => 'Anticheat',
            'slug' => 'anticheat',
        ]);

        Category::factory()->create([
            'name' => 'Chat',
            'slug' => 'chat',
        ]);
        
        Category::factory()->create([
            'name' => 'Developer Tools',
            'slug' => 'developer-tools',
        ]);

        Category::factory()->create([
            'name' => 'Fixes',
            'slug' => 'fixes',
        ]);

        Category::factory()->create([
            'name' => 'Fun',
            'slug' => 'fun',
        ]);

        Category::factory()->create([
            'name' => 'General',
            'slug' => 'general',
        ]);

        Category::factory()->create([
            'name' => 'Informational',
            'slug' => 'informational',
        ]);

        Category::factory()->create([
            'name' => 'Mechanics',
            'slug' => 'mechanics',
        ]);

        Category::factory()->create([
            'name' => 'Miscellaneous',
            'slug' => 'miscellaneous',
        ]);

        Category::factory()->create([
            'name' => 'Moderation',
            'slug' => 'moderation',
        ]);

        Category::factory()->create([
            'name' => 'Multiplayer',
            'slug' => 'multiplayer',
        ]);

        Category::factory()->create([
            'name' => 'Score Submission',
            'slug' => 'score-submission',
        ]);

        Category::factory()->create([
            'name' => 'Security',
            'slug' => 'security',
        ]);

        Category::factory()->create([
            'name' => 'Integration',
            'slug' => 'integration',
        ]);
    }
}
