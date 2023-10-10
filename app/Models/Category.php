<?php

namespace App\Models;

use App\Models\User;
use App\Models\Blogpost;
use App\Models\CacheBlog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, "users_categories_junction", "category_id", "user_id");
    }

    public function blogposts()
    {
        return $this->belongsToMany(Blogpost::class, "blogposts_categories_junction", "category_id", "blogpost_id");
    }

    public function cacheBlogs()
    {
        return $this->belongsToMany(CacheBlog::class, "cache_categories_blogs", "category_id", "cache_blog_id");
    }
}
