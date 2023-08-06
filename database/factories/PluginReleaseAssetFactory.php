<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PluginRelease;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PluginReleaseAsset>
 */
class PluginReleaseAssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'plugin_release_id' => PluginRelease::inRandomOrder()->first()->id,
            'name' => $this->faker->name,
            'path' => 'asdf',
            'type' => $this->faker->randomElement(['web', 'bancho', 'other']),
            'size' => $this->faker->numberBetween(1, 1000000),
            'download_count' => $this->faker->numberBetween(0, 1000000)
        ];
    }
}
