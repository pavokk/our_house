<div class="post-profile flex items-center justify-start gap-4 mb-3">
    <div class="post-profile-pic w-15 h-15">
        <a href="{{ route('user.show', $post->user->slug) }}">
            @if (isset($post->user->image))
                <x-users.profile-picture :imageLocation="asset('storage/' . $post->user->image->image)" :altText="$post->user->image->alt" />
            @else
                <x-svg.placeholder-profile height="64px" width="50px" color="var(--color-main-dark)" />
            @endif
        </a>
    </div>

    <div class="post-profile-name">
        <p>{{ $post->user->name }}</p>
    </div>

</div>