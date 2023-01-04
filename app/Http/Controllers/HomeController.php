<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        // ? Get who we follow
        $ids = auth()->user()->following->pluck('id')->toArray();

        // ? Get the posts from the people we follow
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(10);

        // ? Return the view
        return view('home', compact('posts'));
    }
}
