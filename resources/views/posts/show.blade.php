@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="container mx-auto md:flex mt-10 gap-4">
        <div class="max-w-xl">
            <img class="rounded-lg" src="{{ asset('uploads') . '/' . $post->image }}" alt="{{ $post->title }}">

            <div class="flex gap-4 items-center mt-4">
                <a class="font-bold" href="{{ route('posts.index', ['user' => $post->user]) }}">
                    {{ $post->user->username }}
                </a>

                <p class="text-sm text-gray-500">
                    {{ $post->created_at->diffForHumans() }}
                </p>

                @auth
                    <livewire:like-post :post="$post" />
                @endauth

                @guest
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                        <span>
                            {{ $post->likes->count() }} @choice('Like|Likes', $post->likes->count())
                        </span>
                    </div>
                @endguest

                <div class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                    </svg>

                    <span>
                        {{ $post->comments->count() }} @choice('comment|comments', $post->comments->count())
                    </span>
                </div>

                @auth
                    @if ($post->user_id === auth()->user()->id)
                        <form action="{{ route('posts.destroy', compact('post')) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="bg-red-600 hover:bg-red-500 text-white font-bold cursor-pointer p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>

                            </button>
                        </form>
                    @endif
                @endauth
            </div>

            <p class="mt-5">
                {{ $post->description }}
            </p>
        </div>

        <div class="md:w-full">
            <div class="shadow bg-white p-5 mb-5 rounded-lg">
                <div class="mb-5 max-h-96 overflow-y-scroll @auth border-gray-300 border-b @endauth ">
                    @if (count($post->comments) > 0)
                        @foreach ($post->comments as $comment)
                            <div class="py-5">
                                <p class="text-gray-600">
                                    <a href="{{ route('posts.index', $comment->user) }}"
                                        class="text-sm text-gray-900 font-bold hover:text-gray-500">
                                        {{ $comment->user->name }}
                                    </a>
                                    {{ $comment->body }}
                                </p>
                                <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center text-gray-500 pb-5">No comments yet</p>
                    @endif
                </div>

                <form action="{{ route('posts.comments.store', compact('user', 'post')) }}" method="POST" novalidate
                    class="flex gap-4">
                    @csrf

                    <textarea name="body" id="body" cols="30" rows="1" placeholder="Add a new comment"
                        class="md:w-11/12 text-gray-500 border p-3 rounded-lg resize-none @error('body') border-red-500 @enderror"></textarea>

                    @error('body')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                    <button type="submit"
                        class="md:w-1/12  bg-sky-600 hover:bg-sky-700 font-bold p-3 text-white rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 mx-auto">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                    </button>
                </form>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-2" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

            </div>
        </div>
    @endsection
