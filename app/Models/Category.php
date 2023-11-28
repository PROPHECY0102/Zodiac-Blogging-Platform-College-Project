<?php

namespace App\Models;

use App\Models\User;
use App\Models\Blogpost;
use App\Models\CacheBlog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Models are used for interacting the Database Directly ie to define relationship between tables and to filter results
// Models in Laravel have a powerful tool called Eloquent it is an Object Relational Mapper (ORM) that allows abstracted interaction with the database
// without raw SQL interaction which posed heavy security risk such as unsanitized SQL then leads to SQL injections
// Eloquent Sanitizes SQL before executing it onto the Database
// Models can be imported from the controller and interacted there

class Category extends Model
{
    use HasFactory;

    // Defining relations between Categories and other tables
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
