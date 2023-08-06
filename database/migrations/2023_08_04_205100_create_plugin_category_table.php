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
        Schema::create('category_plugin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plugin_id')->constrained('plugins');
            $table->foreignId('category_id')->constrained('categories');
            $table->timestamps();

            $table->unique(['plugin_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_plugin');
    }
};
