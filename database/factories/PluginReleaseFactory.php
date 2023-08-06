<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Plugin;
use App\Models\PluginRelease;
use App\Models\PluginReleaseAsset;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PluginRelease>
 */
class PluginReleaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'plugin_id' => Plugin::inRandomOrder()->first()->id,
            'version' => $this->faker->numerify('#.#.#'),
            'download_count' => 0,
        ];
    }

    public function withAssets($count = 1)
    {
        return $this->afterCreating(function (PluginRelease $release) use ($count) {
            PluginReleaseAsset::factory()->count($count)->create([
                'plugin_release_id' => $release->id
            ]);
        });
    }
}
