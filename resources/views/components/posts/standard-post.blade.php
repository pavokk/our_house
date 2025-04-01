@props([
    'withLinks' => true,
    'post',
    'users'
    ])

<div class="single-post bg-compliment p-5 rounded-2xl">
    <div class="post-profile flex items-center justify-start">
        <div class="post-profile-pic">
            <a href="{{ route('user.show', $users[$post->user_id]["slug"]) }}" class="block h-16 w-16">
                @if (isset($users[$post->user_id]["image"]))
                    <img src="{{ asset('storage/' . $users[$post->user_id]['image']) }}" alt="{{$users[$post->user_id]['name']}}'s profile picture" class="w-full h-full object-cover rounded-full border-2 border-rose-100"">
                @else
                    <x-svg.placeholder-profile height="64px" width="50px" color="var(--color-main-dark)" />
                @endif
            </a>
        </div>

        <div class="post-profile-name">
            <p>{{ $users[$post->user_id]["name"] }}</p>
        </div>

    </div>

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
                <small>{{ $post->created_at->format('d-m-Y H:i') }} &mdash; <a href="{{ route('user.show', $post->user_id) }}">{{ $users[$post->user_id]["name"] }}</a></small>
            </div>
         
        </div>

    </div>

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

</div>

@pushOnce('styles')

<style>
    div.post-text ol, div.post-text ul {
        list-style: initial;
        padding-left: 18px;
    }

    div.post-text ul {
        list-style: initial;
    }

    div.post-text ol {
        list-style: numbered;
    }

    div.post-text pre {
        @apply whitespace-pre-wrap;
        display: inline;
        font-family: monospace;
        background-color: #f7f7f7;
        border: 1px solid black;
        border-radius: 8px;
    }

    div.post-text blockquote {
        margin: 1rem 0;
        padding: 0.5rem 1rem;
        border-left: 4px solid rgb(147 197 253);
        font-style: italic;
    }
</style>
    
@endPushOnce

@pushOnce('bodyScripts')

<script>

function toggleLike(element, postId) {
    let likeButton = element.closest('.like-button');
    let likeCountElement = likeButton.querySelector('.like-count');
    let likeIcon = likeButton.querySelector('svg path'); // Select the heart path inside SVG
    let likeCount = parseInt(likeCountElement.textContent);
    let isLiked = likeIcon.getAttribute("fill") !== "none"; // Check if the heart is filled

    axios({
        method: isLiked ? 'delete' : 'post',
        url: isLiked ? `/likes/${postId}` : '/likes',
        data: { post_id: postId },
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => {
        if (isLiked) {
            likeCount--;
            likeIcon.setAttribute("fill", "none"); // Remove fill when unliked
        } else {
            likeCount++;
            likeIcon.setAttribute("fill", "var(--color-main-dark)"); // Fill the heart when liked
        }
        likeCountElement.textContent = likeCount;
    })
    .catch(error => console.error("Error:", error));

</script>

@endPushOnce