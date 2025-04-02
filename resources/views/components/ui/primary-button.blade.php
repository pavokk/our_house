@props([
    'bg' => 'bg-main-dark',
    'type' => '',
    'link' => '',
])

@if ($type == 'submit')

    <div {{ $attributes->merge(['class' => "button-submit $bg text-main-light w-full h-11 rounded-lg shadow-md"]) }}>
        <button type="submit" class="w-full h-full flex justify-center items-center cursor-pointer">{{ $slot }}</button>
    </div>

@elseif ($type == 'button')

    <div {{ $attributes->merge(['class' => "button-button $bg text-main-light w-full h-11 rounded-lg shadow-md"]) }}>
        <button type="button" class="w-full h-full flex justify-center items-center cursor-pointer">{{ $slot }}</button>
    </div>

@else

    <div {{ $attributes->merge(['class' => "button-link $bg text-main-light w-full h-11 rounded-lg shadow-md"]) }}>
        <a href="{{ $link }}" class="w-full h-full flex justify-center items-center">{{ $slot }}</a>
    </div>

@endif

