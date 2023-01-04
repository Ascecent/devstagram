@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@push('scripts')
    @vite('resources/js/uploadImage.js')
@endpush

@section('title', 'Create new post')

@section('content')
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold text-center mb-5">New post</h1>

        <div class="md:flex md:items-center md:gap-4">
            <form id="dropzone" action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data"
                class="dropzone border-dashed border-2 w-full h-96 rounded flex flex-col justify-center items-center md:w-1/2 px-10">
                @csrf
            </form>

            <form action="{{ route('posts.store') }}" method="POST"
                class="mt-10 md:mt-0 md:w-1/2 bg-white p-6 rounded-lg shadow-xl" novalidate>
                @csrf

                <label class="mb-3 block capitalize text-gray-500 font-bold" for="title">Title
                    <input type="text" id="title" name="title"
                        class="border p-3 w-full rounded-lg mt-2 @error('title') border-red-500 @enderror"
                        value="{{ old('title') }}" placeholder="Post title">

                    @error('title')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </label>

                <label class="mb-3 block capitalize text-gray-500 font-bold" for="description">Description
                    <textarea name="description" id="description" cols="30" rows="5" placeholder="Post description"
                        class="border p-3 w-full rounded-lg mt-2 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>

                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </label>

                <input type="hidden" name="image" value="{{ old('image') }}">
                @error('image')
                    <div class="mt-6 bg-red-600 text-white text-sm rounded-lg p-4">{{ $message }}</div>
                @enderror

                <button type="submit" class="bg-sky-600 hover:bg-sky-700 font-bold w-full p-3 text-white rounded-lg mt-5 ">
                    Create Post
                </button>
            </form>
        </div>
    </div>
@endsection
