@props([
    'post',
    'users'
    ])


<div class="post-comments bg-compliment p-5 rounded-2xl">

    @if (count($post->comments) <= 0)
        <p>No comments here...</p>
    @else
        @foreach ($post->comments as $comment)
            <p>{!! $comment->comment !!}</p>
        @endforeach
    @endif

</div>