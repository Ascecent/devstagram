@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section class="container mx-auto">
        <h2 class="text-4xl text-center font-black my-10">Home</h2>
        <x-posts-list :posts="$posts" />
    </section>
@endsection
