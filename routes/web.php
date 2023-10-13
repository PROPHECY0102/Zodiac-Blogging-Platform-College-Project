<?php

use App\Http\Controllers\BlogpostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Models\Blogpost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [BlogpostController::class, "index"]);

Route::get("/blogposts/write", [BlogpostController::class, "write"]);

Route::post("/blogposts/write", [BlogpostController::class, "submitToPreview"])->middleware("auth");

Route::get("/blogposts/preview", [BlogpostController::class, "preview"])->middleware("auth");

Route::get("/blogposts/preview/revise", [BlogpostController::class, "revise"])->middleware("auth");

Route::get("/blogposts/preview/discard", [BlogpostController::class, "discard"])->middleware("auth");

Route::get("/blogposts/submit/final", [BlogpostController::class, "store"])->middleware("auth");

Route::get("/blogposts/{blogpost}", [BlogpostController::class, "show"]);

// Register and Login
Route::get("/register", [UserController::class, "register"])->middleware("guest");

Route::post("/register", [UserController::class, "store"]);

Route::get("/login", [UserController::class, "login"])->middleware("guest");

Route::post("/login", [UserController::class, "authenticate"]);

Route::post("/logout", [UserController::class, "logout"]);

// Dashboard
Route::get("/dashboard", [UserController::class, "dashboard"])->middleware("auth");

Route::get("/dashboard/users", [UserController::class, "manageUsers"])->middleware("auth");

Route::get("/dashboard/users/edit/{user}", [UserController::class, "getUser"])->middleware("auth");

Route::get("/dashboard/users/delete/{user}", [UserController::class, "deleteUser"])->middleware("auth");

Route::get("/dashboard/categories", [CategoryController::class, "manageCategories"])->middleware("auth");

Route::get("/dashboard/categories/add", [CategoryController::class, "getCategoryForm"])->middleware("auth");

Route::post("/dashboard/categories/create", [CategoryController::class, "createCategory"])->middleware("auth");

Route::get("/dashboard/categories/edit/{category}", [CategoryController::class, "getCategory"])->middleware("auth");

Route::get("/dashboard/categories/delete/{category}", [CategoryController::class, "deleteCategory"])->middleware("auth");

Route::get("/dashboard/blogposts", [BlogpostController::class, "manageBlogposts"])->middleware("auth");

Route::get("/dashboard/blogposts/delete/{blogpost}", [BlogpostController::class, "deleteBlogpost"])->middleware("auth");
