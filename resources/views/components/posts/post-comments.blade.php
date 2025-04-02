@props([
    'post',
    'users'
    ])

@if (count($post->comments) <= 0)
    <p>Ingen kommentarer enda...</p>
@else
    @foreach ($post->comments as $comment)
        <p>{!! $comment->comment !!}</p>
    @endforeach
@endif