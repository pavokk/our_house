@props([
    'withLinks' => true,
    'event',
    ])

<div class="post-profile flex items-center justify-start gap-4 mb-3">
    <div class="post-profile-pic w-15 h-15">
        <a href="{{ route('user.show', $event->user->slug) }}">
            @if (isset($event->user->image))
                <x-users.profile-picture :imageLocation="asset('storage/' . $event->user->image->image)" :altText="$event->user->image->alt" />
            @else
                <x-svg.placeholder-profile height="64px" width="50px" color="var(--color-main-dark)" />
            @endif
        </a>
    </div>

    <div class="post-profile-name">
        <p>{{ $event->user->name }}</p>
    </div>

</div>


<div class="post-content w-full flex flex-col">

    <div class="post-content flex-grow flex flex-col gap-3 w-full m-0 p-5 bg-main-light rounded-md">

        <div class="post-title">
            @if ($withLinks)
                <a href="{{ route('event.show', $event->slug) }}">
                    <h2 class="text-xl">{{ $event->name }}</h2>
                </a>
            @else
                <h2 class="text-xl">{{ $event->name }}</h2>
            @endif
        </div>

        @if ($event->image)
            <div class="post-image">
                <img src="{{ asset('storage/' . $event->image->image) }}" alt="Post image" style="width: 100%;height:auto;">
            </div>
        @endif

        <div class="post-text break-words overflow-hidden">
            <p>{!! $event->content !!}</p>
            <small>{{ $event->created_at->format('d-m-Y H:i') }} &mdash; <a href="{{ route('user.show', $event->user->slug) }}">{{ $event->user->name }}</a></small>
        </div>

    </div>

</div>
