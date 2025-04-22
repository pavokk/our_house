<x-layouts.main title="Skagesundvegen 63 - Galleri">
    <main class="max-w-3xl m-auto mt-5">

        <x-ui.primary-box class="gallery-images grid grid-cols-2 md:grid-cols-4 gap-4">

            @foreach ($images as $image)

                <x-gallery.square-image :$image />
                
            @endforeach

        </x-ui.primary-box>




    </main>
</x-layouts.main>