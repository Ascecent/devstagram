@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <section class="bg-white py-10">
        <div class="container mx-auto flex justify-center">
            <div class="w-full gap-4 md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
                <div class="w-8/12 lg:w-6/12 px-5 flex justify-end">
                    <img src="{{ $user->image ? asset('profiles') . '/' . $user->image : asset('img/user.png') }}"
                        alt="User avatar" class="rounded-full">
                </div>
                <div class="md:w-8/12 lg:w-6/12 px-5 flex flex-col items-center md:items-start md:justify-center py-10">
                    <h2 class="text-gray-700 text-2xl mb-1 font-bold">{{ $user->name }}</h2>

                    <div class="flex items-center gap-2">
                        <p class="text-gray-700 text-xl">{{ $user->username }}</p>
                        @auth
                            @if ($user->id === auth()->id())
                                <a href="{{ route('profile.index', compact('user')) }}"
                                    class="text-gray-500 hover:text-gray-700 hover:cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                            @endif
                        @endauth
                    </div>

                    <p class="text-gray-800 text-sm mb-3 mt-5 font-bold">
                        {{ $user->followers->count() }}<span class="font-normal"> @choice('follower|followers', $user->followers->count())</span>
                    </p>

                    <p class="text-gray-800 text-sm mb-3 font-bold">
                        {{ $user->following->count() }}<span class="font-normal"> following</span>
                    </p>

                    <p class="text-gray-800 text-sm mb-3 font-bold">
                        {{ $user->posts->count() }}<span class="font-normal"> @choice('post|posts', $user->posts->count())</span>
                    </p>

                    @auth
                        @if (auth()->id() !== $user->id)
                            @if ($user->followedBy(auth()->user()))
                                <form action="{{ route('profile.follow.destroy', compact('user')) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 font-bold w-full px-3 py-1 text-white rounded-lg cursor-pointer">
                                        Unfollow
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('profile.follow.store', compact('user')) }}" method="POST">
                                    @csrf

                                    <button type="submit"
                                        class="bg-sky-600 hover:bg-sky-700 font-bold w-full px-3 py-1 text-white rounded-lg cursor-pointer">
                                        Follow
                                    </button>
                                </form>
                            @endif
                        @endif
                    @endauth

                </div>
            </div>
        </div>
    </section>

    <section class="container mx-auto">
        <h2 class="text-4xl text-center font-black my-10">My posts</h2>
        <x-posts-list :posts="$posts" />
    </section>
@endsection
