<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PluginReleaseAsset extends Model
{
    use HasFactory;

    public function release()
    {
        return $this->belongsTo(PluginRelease::class, 'plugin_release_id');
    }
}
