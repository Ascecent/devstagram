<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // ? Validate request data
        $this->validate($request, [
            'body' => 'required|max:255',
        ]);

        // ? Create comment
        $request->user()->comments()->create([
            'body' => $request->body,
            'post_id' => $request->post,
            'user_id' => auth()->user()->id,
        ]);

        // ? Redirect back to the post
        return back()->with('success', 'Comment created successfully');
    }
}
