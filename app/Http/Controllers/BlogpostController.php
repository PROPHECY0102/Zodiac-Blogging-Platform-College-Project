<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Blogpost;
use App\Models\CacheBlog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

// All Controllers Play a vital role in this Application. Controllers acts as the server middleman processing requests made both by the server and users
// Blogpost Controller handles Pages that interacts with The Blogposts entity and Have access to the Blogpost Model

class BlogpostController extends Controller
{
    // Display Index/Home Page for both signed in Users or guests
    public function index()
    {
        return view(
            "pages.index",
            [
                "blogposts" => Blogpost::latest()->filter(request(["category", "search"]))->paginate(10),
                "categories" => Category::get(),
            ]
        );
    }

    // Display Single Blogpost Page Selected by the User
    public function show(Blogpost $blogpost)
    {
        return view("pages.blog", [
            "blogpost" => $blogpost,
        ]);
    }

    // Display Blogpost Form to publish Blogpost as a user
    public function write()
    {
        if (!Auth::check()) {
            return redirect("/register")->with("message", "You must have a ZODIAC Account to publish blogs");
        }
        return view("pages.write", [
            "categories" => Category::get(),
        ]);
    }

    // Submitting Blogpost data into preview for final revision
    // Uses the CacheBlog Table to temporary store preview blogs before submitting to public database
    public function submitToPreview(Request $request)
    {
        $formFields["title"] = $request->get("title");
        if ($request->has("image")) {
            $formFields["image"] = $request->file("image")->store("cache_images", "public");
        }
        $categoriesIDs = json_decode($request->get("categories"));
        if (count($categoriesIDs) < 1) {
            array_push($categoriesIDs, 1);
        }
        $formFields["content"] = $request->get("content");
        $formFields["user_id"] = auth()->user()->id;

        $cacheBlog = CacheBlog::create($formFields);
        foreach ($categoriesIDs as $id) {
            $cacheBlog->categories()->attach($id);
        }

        return response()->json(["redirect" => "/blogposts/preview"]);
    }

    // Displaying Preview page for newly publish blogpost
    // Can be revise and discarded here
    public function preview()
    {
        $currentUser = User::find(auth()->user()->id);
        $blogData = $currentUser->cacheBlogs()->latest()->first();
        if (is_null($blogData)) {
            return redirect("/");
        }
        return view("pages.preview", [
            "blogData" => $blogData,
        ]);
    }

    // If user choose to revise blogpost return user to editing form
    public function revise()
    {
        $currentUser = User::find(auth()->user()->id);
        $blogData = $currentUser->cacheBlogs()->latest()->first();
        if (is_null($blogData)) {
            return redirect("/");
        }
        $blogDataArray = (array) $blogData;
        $selectedCategories = (array) $blogData->categories;
        $blogData->categories()->detach();
        Artisan::call("custom:clear-cache-images");
        CacheBlog::destroy($blogData->id);
        return view(
            "pages.edit",
            [
                "blogData" => $blogDataArray,
                "selectedCategories" => $selectedCategories,
                "categories" => Category::get(),
            ]
        );
    }

    // Discard the current blogpost in preview if user choose to not publish
    // Deleting Cache Blogpost data from CacheBlog
    public function discard()
    {
        $currentUser = User::find(auth()->user()->id);
        $blogData = $currentUser->cacheBlogs()->latest()->first();
        if (is_null($blogData)) {
            return redirect("/");
        }
        $blogData->categories()->detach();
        Artisan::call("custom:clear-cache-images");
        CacheBlog::destroy($blogData->id);
        return redirect("/")->with("message", "Blogpost Discarded");
    }

    // Submit Blogpost data into public DB and create a new record into Blogposts table
    // Deleting Cache Blogpost data from CacheBlog
    public function store()
    {
        $currentUser = User::find(auth()->user()->id);
        $blogData = $currentUser->cacheBlogs()->latest()->first();
        if (is_null($blogData)) {
            return redirect("/");
        }
        $finalField["title"] = $blogData->title;
        $cacheImage = $blogData->image;
        if ($cacheImage) {
            $extension = File::extension($cacheImage);
            $newFilePath = "blog_images/" . uniqid() . "." . $extension;
            if (Storage::disk('public')->copy($cacheImage, $newFilePath)) {
                $finalField["image"] = $newFilePath;
            }
        }

        $finalField["content"] = $blogData->content;
        $finalField["user_id"] = auth()->user()->id;
        $newBlog = Blogpost::create($finalField);
        foreach ($blogData->categories as $category) {
            $newBlog->categories()->attach($category->id);
        }
        $blogData->categories()->detach();
        Artisan::call("custom:clear-cache-images");
        CacheBlog::destroy($blogData->id);
        return redirect("/blogposts" . "/" . $newBlog->id)->with("message", "Your Blog has been publish on ZODIAC");
    }

    // Displaying all Blogposts from Dashboard Page
    public function manageBlogposts()
    {
        if (auth()->user()->role !== "Admin") {
            return abort(404);
        }
        return view(
            "pages.dashboard.blogposts",
            [
                "blogposts" => Blogpost::paginate(10),
            ]
        );
    }

    // Delete Selected Blogpost from DB
    public function deleteBlogpost(Blogpost $blogpost)
    {
        if (auth()->user()->role !== "Admin") {
            return abort(404);
        }
        $id = $blogpost->id;
        $blogpost->categories()->detach();
        Blogpost::destroy($id);
        return redirect("/dashboard/blogposts")->with("message", "Blogpost " . $id . " has been deleted");
    }
}
