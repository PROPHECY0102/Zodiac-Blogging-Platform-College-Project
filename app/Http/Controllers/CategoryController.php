<?php

namespace App\Http\Controllers;

use App\Models\Blogpost;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

// All Controllers Play a vital role in this Application. Controllers acts as the server middleman processing requests made both by the server and users
// Category Controller handles Pages that interacts with The Categories entity and Have access to the Category Model

class CategoryController extends Controller
{
    // WIP! For Displaying and Managing User Followed Categories Does not work for now
    public function userCategories()
    {
        if (!Auth::check()) {
            return redirect("/register")->with("message", "You must have a ZODIAC Account to view followed categories");
        }
        return view("pages.userCategories", [
            "categories" => Category::get(),
            "blogposts" => Blogpost::latest()->filter(request(["category"]))->paginate(10),
        ]);
    }

    // Display All Categories from Dashboard Page
    public function manageCategories()
    {
        if (auth()->user()->role !== "Admin") {
            return abort(404);
        }
        return view("pages.dashboard.categories", [
            "categories" => Category::paginate(10),
        ]);
    }

    // Displaying Form to add new Categories from Dashboard Page
    public function getCategoryForm()
    {
        if (auth()->user()->role !== "Admin") {
            return abort(404);
        }
        return view("pages.dashboard.addCategories");
    }

    // Create New Categories into Database via addCategories form from Dashboard page
    public function createCategory(Request $request)
    {
        if (auth()->user()->role !== "Admin") {
            return abort(404);
        }

        $formFields = $request->validate([
            "name" => ["required", "min:3", Rule::unique("categories", "name")]
        ]);

        if ($request->hasFile("default_image")) {
            $formFields["default_image"] = $request->file("default_image")->store("categories_images", "public");
        }

        Category::create($formFields);

        return redirect("/dashboard/categories")->with("message", "New Category has been added");
    }

    // Get data for Single Category in Dashboard with feature to edit Categories Details from Dashboard WIP!
    public function getCategory(Category $category)
    {
        if (auth()->user()->role !== "Admin") {
            return abort(404);
        }
        return view("pages.dashboard.editCategory", [
            "category" => $category,
        ]);
    }

    // Delete selected category from Dashboard Page
    public function deleteCategory(Category $category)
    {
        if (auth()->user()->role !== "Admin") {
            return abort(404);
        }
        $categorySelected = $category->name;
        Category::destroy($category->id);
        return redirect("/dashboard/categories")->with("message", "Category " . $categorySelected . " has been deleted");
    }
}
