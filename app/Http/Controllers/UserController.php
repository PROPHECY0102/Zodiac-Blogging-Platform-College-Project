<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register()
    {
        return view("pages.register");
    }

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

    public function logout(Request $request)
    {
        auth()->logout();

        // Refresh Session for next user
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out!');
    }

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

    public function login()
    {
        return view("pages.login");
    }

    public function dashboard()
    {
        if (auth()->user()->role !== "Admin") {
            return abort(404);
        }
        return view("pages.dashboard.home");
    }

    public function manageUsers()
    {
        if (auth()->user()->role !== "Admin") {
            return abort(404);
        }
        return view("pages.dashboard.users", [
            "users" => User::paginate(10),
        ]);
    }

    public function getUser(User $user)
    {
        if (auth()->user()->role !== "Admin") {
            return abort(404);
        }
        return view("pages.dashboard.editUser", [
            "user" => $user,
        ]);
    }

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
