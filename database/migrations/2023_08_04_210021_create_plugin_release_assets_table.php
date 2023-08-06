<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plugin_release_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plugin_release_id')->constrained('plugin_releases');
            $table->string('name');
            $table->string('path');
            $table->integer('size');
            $table->enum('type', ['web', 'bancho', 'other']);
            $table->integer('download_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plugin_release_assets');
    }
};
