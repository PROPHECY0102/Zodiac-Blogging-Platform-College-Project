<?php

use App\Models\Blogpost;
use App\Models\Category;
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
        Schema::create('blogposts_categories_junction', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Blogpost::class)->onDelete("cascade");
            $table->foreignIdFor(Category::class)->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogposts_categories_junction');
    }
};
