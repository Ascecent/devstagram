<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        if (auth()->check())
            return redirect()->route('posts.index', auth()->user()->slug);

        return view('auth.register');
    }

    public function store(Request $request)
    {
        // ? Validate the request data
        $this->validate($request, [
            'name' => 'required|max:30',
            'username' => 'required|min:3|max:20|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        // ? Save record in the database
        User::create([
            'name' => $request->name,
            'username' => Str::lower($request->username),
            'slug' => Str::slug($request->username),
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // ? Attempt to authenticate the user
        auth()->attempt($request->only('email', 'password'));

        // ? Redirect to the user wall
        return redirect()->route('posts.index', auth()->user()->slug);
    }
}
