@props([
    'post',
    ])

@if (count($post->comments) <= 0)
    <p>Ingen kommentarer enda...</p>
@else
    @foreach ($post->comments as $comment)
    <div class="mb-3">
        <p>{!! $comment->comment !!}</p>
        <small>{{ $comment->created_at->format('d-m-Y H:i') }} &mdash; <a href="{{ route('user.show', $comment->user->slug) }}">{{ $comment->user->name }}</a></small>
    </div>
    @endforeach
@endif