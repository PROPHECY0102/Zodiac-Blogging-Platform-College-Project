<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Blogpost;
use App\Models\Category;
use App\Models\CacheBlog;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// Models are used for interacting the Database Directly ie to define relationship between tables and to filter results
// Models in Laravel have a powerful tool called Eloquent it is an Object Relational Mapper (ORM) that allows abstracted interaction with the database
// without raw SQL interaction which posed heavy security risk such as unsanitized SQL then leads to SQL injections
// Eloquent Sanitizes SQL before executing it onto the Database
// Models can be imported from the controller and interacted there

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Defining relations between Users and other tables
    public function blogposts()
    {
        return $this->hasMany(Blogpost::class);
    }

    public function cacheBlogs()
    {
        return $this->hasMany(CacheBlog::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, "users_categories_junction", "user_id", "category_id");
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, "followers", "following", "follower");
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, "followers", "followers", "following");
    }
}
