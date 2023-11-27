<?php

namespace App\Http\Controllers;

use App\Models\Blogpost;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
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

    public function manageCategories()
    {
        if (auth()->user()->role !== "Admin") {
            return abort(404);
        }
        return view("pages.dashboard.categories", [
            "categories" => Category::paginate(10),
        ]);
    }

    public function getCategoryForm()
    {
        if (auth()->user()->role !== "Admin") {
            return abort(404);
        }
        return view("pages.dashboard.addCategories");
    }

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

    public function getCategory(Category $category)
    {
        if (auth()->user()->role !== "Admin") {
            return abort(404);
        }
        return view("pages.dashboard.editCategory", [
            "category" => $category,
        ]);
    }

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
