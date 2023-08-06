<?php

namespace App\Observers;

use App\Models\PluginRelease;

class PluginReleaseObserver
{
    /**
     * Handle the PluginRelease "created" event.
     */
    public function created(PluginRelease $pluginRelease): void
    {
        $pluginRelease->plugin->increment('download_count', $pluginRelease->download_count);
        dump("foo");
    }

    /**
     * Handle the PluginRelease "updated" event.
     */
    public function updated(PluginRelease $pluginRelease): void
    {
        if ($pluginRelease->isDirty('download_count')) {
            // We need to calculate the difference between the old and new download count in case of a large download increase
            // Like if the development seeder was ran
            $difference = $pluginRelease->getOriginal('download_count') - $pluginRelease->download_count;
            $pluginRelease->plugin->increment('download_count', $difference);
        }
    }

    /**
     * Handle the PluginRelease "deleted" event.
     */
    public function deleted(PluginRelease $pluginRelease): void
    {
        $pluginRelease->plugin->decrement('download_count', $pluginRelease->download_count);
    }

    /**
     * Handle the PluginRelease "restored" event.
     */
    public function restored(PluginRelease $pluginRelease): void
    {
        //
    }

    /**
     * Handle the PluginRelease "force deleted" event.
     */
    public function forceDeleted(PluginRelease $pluginRelease): void
    {
        //
    }
}
