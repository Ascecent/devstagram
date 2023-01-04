@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <h1 class="text-3xl font-bold text-center mt-10">Edit profile: {{ $user->username }}</h1>

    <div class="md:flex md:justify-center mt-10">
        <form class="md:w-1/2 bg-white shadow p-6 mt-10 md:mt-0" action="{{ route('profile.store', compact('user')) }}"
            enctype="multipart/form-data" method="POST">
            @csrf

            <label class="mb-3 block capitalize text-gray-500 font-bold" for="username">Username
                <input type="text" id="username" name="username"
                    class="border p-3 w-full rounded-lg mt-2 @error('username') border-red-500 @enderror"
                    value="{{ old('username') }}" placeholder="Username">

                @error('username')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </label>

            <label class="mb-3 block capitalize text-gray-500 font-bold" for="image">Profile picture
                <input type="file" id="image" name="image"
                    class="border p-3 w-full rounded-lg mt-2 @error('image') border-red-500 @enderror"
                    value="{{ auth()->user()->username }}" accept=".jpg, .jpeg, .png">

                @error('image')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </label>

            <button type="submit" class="bg-sky-600 hover:bg-sky-700 font-bold w-full p-3 text-white rounded-lg mt-5 ">
                Save changes
            </button>
        </form>
    </div>
@endsection
