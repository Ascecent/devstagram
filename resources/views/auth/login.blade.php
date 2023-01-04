@extends('layouts.app')

@section('title', 'Log in')

@section('content')
    <div class="md:flex justify-center md:gap-10 md:items-center container mx-auto mt-10">
        <div class="md:w-5/12">
            <img src="{{ asset('img/login.svg') }}" alt="Join Us">
        </div>

        <form action="{{ route('login') }}" method="POST" class="md:w-4/12 bg-white p-6 rounded-lg shadow-xl" novalidate>
            @csrf

            <h1 class="text-3xl font-bold text-center mb-5">Log in</h1>

            <label class="mb-3 block capitalize text-gray-500 font-bold" for="email">Email
                <input type="email" id="email" name="email"
                    class="border p-3 w-full rounded-lg mt-2 @error('email') border-red-500 @enderror"
                    value="{{ old('email') }}" placeholder="bob@example.com">

                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </label>

            <label class="mb-3 block capitalize text-gray-500 font-bold" for="password">Password
                <input type="password" id="password" name="password"
                    class="border p-3 w-full rounded-lg mt-2 @error('password') border-red-500 @enderror"
                    value="{{ old('password') }}" placeholder="*****">

                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </label>

            @if (session('status'))
                <div class="bg-red-500 p-3 rounded-lg text-white text-center mb-3">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mb-5 mt-3">
                <input type="checkbox" name="remember" id="remember" class="mr-2">
                <label for="remember" class="text-gray-500 font-bold">Remember me</label>
            </div>

            <button type="submit" class="bg-sky-600 hover:bg-sky-700 font-bold w-full p-3 text-white rounded-lg mt-5 ">
                Log in
            </button>
        </form>
    </div>
@endsection
