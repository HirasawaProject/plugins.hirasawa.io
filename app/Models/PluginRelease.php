<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PluginRelease extends Model
{
    use HasFactory;

    public function plugin()
    {
        return $this->belongsTo(Plugin::class);
    }

    public function assets()
    {
        return $this->hasMany(PluginReleaseAsset::class);
    }
}
