<div class="bg-lightbrown p-5 rounded-lg flex gap-5 items-center">
    <div class="post-profile w-16 h-16">
        <a href="{{ route('user.show', $post->user_id) }}" class="block h-16 w-16">
            @if (isset($users[$post->user_id]["image"]))
                <img src="{{ asset('storage/' . $users[$post->user_id]['image']) }}" alt="{{$users[$post->user_id]['name']}}'s profile picture" class="w-full h-full object-cover rounded-full border-2 border-rose-100"">
            @else
                <x-svg.placeholder-profile height="64px" width="50px" />
            @endif
        </a>
    </div>

    <div class="post-content flex-grow flex flex-col gap-3 w-full m-0 p-0">

        @if ($post->image)
            <div class="post-image bg-primary-yellow rounded-md p-5">
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" style="width: 100%;height:auto;">
            </div>
        @endif

        <div class="post-text bg-primary-yellow rounded-md p-5 break-words overflow-hidden">
            <p>{!! $post->content !!}</p>
            <small>{{ $post->created_at->format('d-m-Y H:i') }} &mdash; <a href="{{ route('user.show', $post->user_id) }}">{{ $users[$post->user_id]["name"] }}</a></small>
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