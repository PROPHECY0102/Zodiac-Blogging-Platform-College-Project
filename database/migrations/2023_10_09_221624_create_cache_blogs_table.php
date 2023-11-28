<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // A Table for temporary Caching Blogpost for preview without publishing it on public Blogpost Table
    public function up(): void
    {
        Schema::create('cache_blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->onDelete("cascade");
            $table->string("title");
            $table->string("image")->nullable();
            $table->json("content");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache_blogs');
    }
};
