<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        // ? Validate that the file is an image and has a maximum size of 2MB
        $this->validate($request, [
            'file' => 'required|image|max:2048'
        ]);

        // ? Get the file from the request
        $image = $request->file('file');

        // ? Create image filename
        $imageName = Str::uuid() . '.' . $image->extension();

        // ? Apply intervention manipulation
        $interventionImage = Image::make($image)
            ->fit(1000, 1000);

        // ? Save the image in /public/uploads
        $imagePath = public_path('uploads') . '/' . $imageName;
        $interventionImage->save($imagePath);

        // ? Return the generated filename
        return response()->json(['image' => $imageName]);
    }
}
