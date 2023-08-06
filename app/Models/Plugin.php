<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
    use HasFactory;

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function releases()
    {
        return $this->hasMany(PluginRelease::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
