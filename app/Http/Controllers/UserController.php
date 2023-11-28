<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

// All Controllers Play a vital role in this Application. Controllers acts as the server middleman processing requests made both by the server and users
// User Controller handles Pages that interacts with The Users entity and Have access to the User Model

class UserController extends Controller
{
    // Display Register Page
    public function register()
    {
        return view("pages.register");
    }

    // Validating and Registering new user accounts to users table in the database
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'username' => ['required', 'min:3', "alpha_dash", Rule::unique("users", "username")],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ["required", "confirmed", "min:6"],
        ]);

        // Normal Role by Default
        $formFields["role"] = "Normal";

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create User
        $user = User::create($formFields);

        // Login
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in!');
    }

    // Logging Out User
    public function logout(Request $request)
    {
        auth()->logout();

        // Refresh Session for next user
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out!');
    }

    // Display Login Page
    public function login()
    {
        return view("pages.login");
    }

    // Authenticate Login Credentials
    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You are now logged in!');
        }

        return back()->withErrors(['username' => 'Invalid Credentials'])->onlyInput('username');
    }

    // Display Dashboard Page (Requires Admin Role)
    public function dashboard()
    {
        if (auth()->user()->role !== "Admin") {
            return abort(404);
        }
        return view("pages.dashboard.home");
    }

    // Display all Users in Dashboard
    public function manageUsers()
    {
        if (auth()->user()->role !== "Admin") {
            return abort(404);
        }
        return view("pages.dashboard.users", [
            "users" => User::paginate(10),
        ]);
    }

    // Get data for Single User in Dashboard with feature to edit User Credential from Dashboard WIP!
    public function getUser(User $user)
    {
        if (auth()->user()->role !== "Admin") {
            return abort(404);
        }
        return view("pages.dashboard.editUser", [
            "user" => $user,
        ]);
    }

    // Functionality to delete selected user from Dashboard
    public function deleteUser(User $user)
    {
        if (auth()->user()->role !== "Admin") {
            return abort(404);
        }
        $currentUsername = $user->username;
        User::destroy($user->id);
        return redirect("/dashboard/users")->with("message", "User " . $currentUsername . " has been deleted");
    }
}
