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
        Schema::create('plugins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longtext('description');
            $table->string('version')->nullable();
            $table->boolean('is_public')->default(false);
            $table->foreignId('author_id')->constrained('users');
            $table->string('support_url')->nullable();
            $table->string('source_url')->nullable();
            $table->enum('targeting', ['web', 'bancho', 'both'])->default('both');
            $table->integer('download_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->timestamps();

            $table->unique(['name', 'author_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plugins');
    }
};
