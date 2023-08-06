<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Plugin;
use App\Models\PluginRelease;
use App\Models\PluginComment;
use App\Models\User;
use App\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plugin>
 */
class PluginFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'is_public' => $this->faker->boolean,
            'author_id' => User::inRandomOrder()->first()->id,
            'support_url' => $this->faker->url,
            'source_url' => $this->faker->url,
            'targeting' => $this->faker->randomElement(['web', 'bancho', 'both']),
        ];
    }

    public function withReleases(int $count = 1): self
    {
        return $this->afterCreating(function (Plugin $plugin) use ($count) {
            PluginRelease::factory()->withAssets(3)->count($count)->create([
                'plugin_id' => $plugin->id
            ]);
        });
    }

    public function withComments(int $count = 1): self
    {
        return $this->afterCreating(function (Plugin $plugin) use ($count) {
            PluginComment::factory()->count($count)->create([
                'plugin_id' => $plugin->id
            ]);
        });
    }

    public function giveAuthorRole(): self
    {
        return $this->afterCreating(function (Plugin $plugin) {
            if ($plugin->author->roles()->where('name', 'Plugin Developer')->exists()) {
                return;
            }
            $plugin->author->roles()->attach(Role::where('name', 'Plugin Developer')->first());
        });
    }
}
