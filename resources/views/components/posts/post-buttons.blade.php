<div class="post-buttons flex justify-end mt-3 gap-4">

    <div class="like-button flex gap-1 items-center" data-post-id="{{ $post->id }}">
        <span class="font-bold text-sm like-count">{{ count($post->likes) }}</span>
        <x-svg.heart width="30px" height="30px" :isLiked="$post->isLikedBy(auth()->user())" class="like-icon cursor-pointer" onclick="toggleLike(this, {{ $post->id }})" />
    </div>

    <div class="comment-button flex gap-1 items-center">
        <span class="font-bold text-sm">{{ count($post->comments) }}</span>
        @if ($withLinks)
            <a href="{{ route('post.show', $post->slug) }}">
                <x-svg.message width="30px" height="30px" color="var(--color-main-dark)" />
            </a>
        @else
            <x-svg.message width="30px" height="30px" color="var(--color-main-dark)" />
        @endif
    </div>

</div>