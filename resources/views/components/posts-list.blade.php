@if (count($posts) === 0)
    <div class="flex items-center flex-col">
        <p class="text-center text-gray-600 text-md font-bold">There's no posts to show...</p>
        <img src="{{ asset('img/no-posts.svg') }}" alt="No posts to show" class="max-w-2xl">
    </div>
@else
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($posts as $post)
            <article>
                <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
                    <img src="{{ asset('uploads') . '/' . $post->image }}" alt="{{ $post->title }}" class="rounded-lg">
                </a>
            </article>
        @endforeach
    </div>

    <div class="mt-10">
        {{ $posts->links() }}
    </div>
@endif
