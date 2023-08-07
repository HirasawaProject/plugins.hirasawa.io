<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Plugin; // Import the Plugin model
use Inertia\Inertia;

class PluginController extends Controller
{

    public function browse(Request $request)
    {
        
        $category_id = $request->get('category');
        $targeting = $request->get('targeting');
        
        $query = Plugin::where('is_public', true)->with('author');

        if ($category_id && $category_id != 'unlisted') {
            $query->whereHas('categories', function ($q) use ($category_id) {
                $q->where('category_id', $category_id);
            });
        } elseif ($category_id == 'unlisted') {
            $query->whereDoesntHave('categories');
        }

        if ($targeting) {
            $query->where('targeting', $targeting);
        }

        $plugins = $query->get();
        $categories = Category::all()->push((object)['id' => 'unlisted', 'name' => 'Unlisted']);

        return Inertia::render('Browse', compact('plugins', 'categories'));
    }
    
    
    public function show($pluginId)
    {
        $plugin = Plugin::with('author')->find($pluginId);
    
        if (!$plugin) {
            abort(404);
        }
    
        return Inertia::render('Plugins/PluginDetail', ['plugin' => $plugin]); // Note the updated path
    }


}