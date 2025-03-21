@if (isset($type) && $type == 'button')

    <div class="button-link bg-darkbrown text-white w-full h-11 rounded-lg shadow-md">
        <button type="submit" class="w-full h-full flex justify-center items-center">{{ $slot }}</button>
    </div>

@else

    <div class="button-link bg-darkbrown text-white w-full h-11 rounded-lg shadow-md">
        <a href="{{ $link }}" class="w-full h-full flex justify-center items-center">{{ $slot }}</a>
    </div>

@endif

