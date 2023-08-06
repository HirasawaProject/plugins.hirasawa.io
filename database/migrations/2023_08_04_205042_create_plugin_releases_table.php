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
        Schema::create('plugin_releases', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longtext('description');
            $table->foreignId('plugin_id')->constrained('plugins');
            $table->string('version');
            $table->integer('download_count')->default(0);
            $table->timestamps();

            $table->unique(['plugin_id', 'version']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plugin_releases');
    }
};
