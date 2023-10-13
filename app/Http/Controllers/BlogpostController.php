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

class BlogpostController extends Controller
{
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

    public function show(Blogpost $blogpost)
    {
        return view("pages.blog", [
            "blogpost" => $blogpost,
        ]);
    }

    public function write()
    {
        if (!Auth::check()) {
            return redirect("/register")->with("message", "You must have a ZODIAC Account to publish blogs");
        }
        return view("pages.write", [
            "categories" => Category::get(),
        ]);
    }

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
