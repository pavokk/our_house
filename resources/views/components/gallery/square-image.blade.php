@props(['image'])

<div class="aspect-square overflow-hidden">
    <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->alt }}" class="w-full h-full object-cover">
</div>