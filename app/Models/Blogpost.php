<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blogpost extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filters)
    {
        if ($filters["category"] ?? false) {
            $query->whereHas("categories", function ($query) {
                $query->where("categories.id", request("category"));
            });
        }
        if ($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('content', 'like', '%' . request('search') . '%');
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, "blogposts_categories_junction", "blogpost_id", "category_id");
    }
}
