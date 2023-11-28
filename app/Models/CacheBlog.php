<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Models are used for interacting the Database Directly ie to define relationship between tables and to filter results
// Models in Laravel have a powerful tool called Eloquent it is an Object Relational Mapper (ORM) that allows abstracted interaction with the database
// without raw SQL interaction which posed heavy security risk such as unsanitized SQL then leads to SQL injections
// Eloquent Sanitizes SQL before executing it onto the Database
// Models can be imported from the controller and interacted there

class CacheBlog extends Model
{
    use HasFactory;

    // Defining Relations between CacheBlog table and other tables
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, "cache_categories_blogs", "cache_blog_id", "category_id");
    }
}
