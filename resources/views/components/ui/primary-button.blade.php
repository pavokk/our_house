@if (isset($type) && $type == 'submit')

    <div {{ $attributes->merge(['class' => "button-submit bg-darkbrown text-white w-full h-11 rounded-lg shadow-md"]) }}>
        <button type="submit" class="w-full h-full flex justify-center items-center">{{ $slot }}</button>
    </div>

@elseif (isset($type) && $type == 'button')

    <div {{ $attributes->merge(['class' => "button-button bg-darkbrown text-white w-full h-11 rounded-lg shadow-md"]) }}>
        <button type="button" class="w-full h-full flex justify-center items-center">{{ $slot }}</button>
    </div>

@else

    <div {{ $attributes->merge(['class' => "button-link bg-darkbrown text-white w-full h-11 rounded-lg shadow-md"]) }}>
        <a href="{{ $link }}" class="w-full h-full flex justify-center items-center">{{ $slot }}</a>
    </div>

@endif

