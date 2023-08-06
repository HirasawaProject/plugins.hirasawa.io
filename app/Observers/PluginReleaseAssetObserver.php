<?php

namespace App\Observers;

use App\Models\PluginReleaseAsset;

class PluginReleaseAssetObserver
{
    /**
     * Handle the PluginReleaseAsset "created" event.
     */
    public function created(PluginReleaseAsset $pluginReleaseAsset): void
    {
        $pluginReleaseAsset->release->increment('download_count', $pluginReleaseAsset->download_count);
    }

    /**
     * Handle the PluginReleaseAsset "updated" event.
     */
    public function updated(PluginReleaseAsset $pluginReleaseAsset): void
    {
        if ($pluginReleaseAsset->isDirty('download_count')) {
            $pluginReleaseAsset->release->increment('download_count');
        }
    }

    /**
     * Handle the PluginReleaseAsset "deleted" event.
     */
    public function deleted(PluginReleaseAsset $pluginReleaseAsset): void
    {
        $pluginReleaseAsset->release->decrement('download_count', $pluginReleaseAsset->download_count);
    }

    /**
     * Handle the PluginReleaseAsset "restored" event.
     */
    public function restored(PluginReleaseAsset $pluginReleaseAsset): void
    {
        //
    }

    /**
     * Handle the PluginReleaseAsset "force deleted" event.
     */
    public function forceDeleted(PluginReleaseAsset $pluginReleaseAsset): void
    {
        //
    }
}
