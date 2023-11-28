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

class Blogpost extends Model
{
    use HasFactory;

    // Function to filter result based on User Search input and selected categories
    // Only one category at a time works for now
    // Filtering multiple categories is still WIP!
    public function scopeFilter($query, array $filters)
    {
        if ($filters["category"] ?? false) {
            $query->whereHas("categories", function ($query) {
                $filteredCategories = request("category");
                $categoryArray = explode(",", $filteredCategories);
                foreach ($categoryArray as $category) {
                    $query->where("categories.id", $category);
                }
            });
        }
        if ($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('content', 'like', '%' . request('search') . '%');
        }
    }

    // Defining Relations between Blogpost and other Tables
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, "blogposts_categories_junction", "blogpost_id", "category_id");
    }
}
