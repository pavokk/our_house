@props(['image'])

<div class="aspect-square overflow-hidden">
    <img src="{{ $image->full_image_url }}" alt="{{ $image->alt }}" class="w-full h-full object-cover">
</div>
