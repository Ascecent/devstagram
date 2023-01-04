@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="md:flex justify-center md:gap-10 md:items-center container mx-auto mt-10">
        <div class="md:w-5/12">
            <img src="{{ asset('img/register.svg') }}" alt="Join Us">
        </div>

        <form action="{{ route('register.store') }}" method="POST" class="md:w-4/12 bg-white p-6 rounded-lg shadow-xl"
            novalidate>
            @csrf

            <h1 class="text-3xl font-bold text-center mb-5">Register</h1>
            <label class="mb-3 block capitalize text-gray-500 font-bold" for="name">Name
                <input type="text" id="name" name="name"
                    class="border p-3 w-full rounded-lg mt-2 @error('name') border-red-500 @enderror"
                    value="{{ old('name') }}" placeholder="Bob Example">

                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </label>

            <label class="mb-3 block capitalize text-gray-500 font-bold" for="username">Username
                <input type="text" id="username" name="username"
                    class="border p-3 w-full rounded-lg mt-2 @error('username') border-red-500 @enderror"
                    value="{{ old('username') }}" placeholder="bobexample">

                @error('username')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </label>

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

            <label class="mb-3 block capitalize text-gray-500 font-bold" for="password_confirmation">Confirm your password
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="border p-3 w-full rounded-lg mt-2 @error('password_confirmation') border-red-500 @enderror"
                    value="{{ old('password_confirmation') }}" placeholder="*****">

                @error('password_confirmation')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </label>

            <button type="submit" class="bg-sky-600 hover:bg-sky-700 font-bold w-full p-3 text-white rounded-lg mt-5 ">
                Create Account
            </button>
        </form>
    </div>
@endsection
