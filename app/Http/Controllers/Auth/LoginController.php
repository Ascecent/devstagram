<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('posts.index', auth()->user()->slug);
        }

        return view('auth.login');
    }

    public function store(Request $request)
    {
        // ? Validate the request
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // ? Sign the user in
        if (!auth()->attempt($request->only('email', 'password'), $request->remember)) {
            return back()->with('status', 'Invalid login details');
        }

        // ? Redirect
        return redirect()->route('posts.index', auth()->user()->slug);
    }

    public function destroy()
    {
        auth()->logout();

        return redirect()->route('login.index');
    }
}
