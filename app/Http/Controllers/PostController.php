<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function index(User $user)
    {
        return view('profile', [
            'user' => $user,
            'posts' => $user->posts()->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // Validate request data
        $this->validate($request, [
            'title' => 'required|max:100',
            'description' => 'required',
            'image' => 'required|max:50',
        ]);

        // Create post

        // ? Ways to create a record in the database
        // ? First one, using the create method of the model
        /* Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
            'user_id' => auth()->user()->id,
        ]); */

        // ? Second one, creating the model, assigning the values and save it
        /* $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->image = $request->image;
        $post->user_id = auth()->user()->id;
        $post->save(); */

        // ? Third one, using the create method from the user model through the relationship
        $request->user()->posts()->create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
            'user_id' => auth()->user()->id
        ]);


        // Redirect to the main page
        return redirect()->route('posts.index', auth()->user()->slug);
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show', compact('post', 'user'));
    }

    public function destroy(Post $post)
    {
        // ? Check if the user is authorized to delete the post
        $this->authorize('delete', $post);

        // ? Delete post
        $post->delete();

        // ? Delete image
        $imagePath = public_path('uploads/' . $post->image);
        if (File::exists($imagePath)) {
            unlink($imagePath);
        }

        // ? Redirect to the main page
        return redirect()->route('posts.index', auth()->user()->slug);
    }
}
