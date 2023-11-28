<?php

use App\Models\Category;
use App\Models\CacheBlog;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Table for Cached blogposts attached Categories similar to blogposts_categories_junction but it is for Cache Blogs
    public function up(): void
    {
        Schema::create('cache_categories_blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CacheBlog::class)->onDelete("cascade");
            $table->foreignIdFor(Category::class)->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache_categories_blogs');
    }
};
