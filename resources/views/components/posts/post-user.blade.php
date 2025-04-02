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