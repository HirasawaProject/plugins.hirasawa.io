<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevelopmentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $plugin_ids = DB::table('plugins')->pluck('id');

        
        $category_ids = DB::table('categories')->pluck('id');

        
        foreach ($plugin_ids as $plugin_id) {
            
            $num_categories = rand(1, min(5, count($category_ids)));
            $chosen_categories_keys = array_rand($category_ids->toArray(), $num_categories);

            
            if (!is_array($chosen_categories_keys)) {
                $chosen_categories_keys = [$chosen_categories_keys];
            }

            
            foreach ($chosen_categories_keys as $key) {
                DB::table('category_plugin')->insert([
                    'plugin_id' => $plugin_id,
                    'category_id' => $category_ids[$key],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}