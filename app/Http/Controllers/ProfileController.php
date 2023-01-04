<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        if ($user->isNot(auth()->user())) {
            abort(403);
        }

        return view('profile.index', compact('user'));
    }

    public function store(Request $request)
    {
        // ? Validate that the file is an image and has a maximum size of 2MB
        $this->validate($request, [
            'username' => ['required', 'min:3', 'max:20', 'unique:users,username,' . auth()->id(), 'not_in:twitter,facebook,instagram,devstagram,edit,delete,logout,login,register,home,posts,images,comments,likes,profile'],
            'image' => ['image', 'max:2048', 'mimes:jpeg,png,jpg'],
        ]);

        // ? If there's an image in the request, then apply Intervention image manipulation
        if ($request->file('image')) {
            // ? Get the file from the request
            $image = $request->file('image');

            // ? Create image filename
            $imageName = Str::uuid() . '.' . $image->extension();

            // ? Apply intervention manipulation
            $interventionImage = Image::make($image)
                ->fit(1000, 1000);

            // ? Save the image in /public/uploads
            $basePath = public_path('profiles') . '/';
            $imagePath = $basePath . $imageName;
            $interventionImage->save($imagePath);

            // ? Delete the old image
            if ($request->user()->image && File::exists($basePath . $request->user()->image)) {
                unlink($basePath . $request->user()->image);
            }
        }

        // ? Save the info from the request
        $user = User::find(auth()->id());
        $user->username = $request->username;
        $user->slug = Str::slug($request->username);
        $user->image = $imageName ?? $request->user()->image;
        $user->save();

        // ? Redirect to the profile page
        return redirect()->to(route('posts.index', compact('user')));
    }
}
