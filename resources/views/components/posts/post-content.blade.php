<div class="post-content w-full flex flex-col">

    <div class="post-content flex-grow flex flex-col gap-3 w-full m-0 p-5 bg-main-light rounded-md">

        <div class="post-title">
            @if ($withLinks)
                <a href="{{ route('post.show', $post->slug) }}">
                    <h2 class="text-xl">{{ $post->title }}</h2>
                </a>
            @else
                <h2 class="text-xl">{{ $post->title }}</h2>
            @endif
        </div>

        @if ($post->image)
            <div class="post-image">
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" style="width: 100%;height:auto;">
            </div>
        @endif

        <div class="post-text break-words overflow-hidden">
            <p>{!! $post->content !!}</p>
            <small>{{ $post->created_at->format('d-m-Y H:i') }} &mdash; <a href="{{ route('user.show', $post->user->slug) }}">{{ $post->user->name }}</a></small>
        </div>
     
    </div>

</div>