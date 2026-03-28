<x-layouts.main title="Skagesundvegen 63 - Spill">
    <main class="max-w-3xl m-auto mt-5 pt-5">

        <x-ui.primary-box>
            <div class="flex items-center gap-4">
                <x-svg.gaming width="48px" height="48px" />
                <div>
                    <h1 class="text-3xl">Spill</h1>
                    <p>Velg et spill å spille</p>
                </div>
            </div>
        </x-ui.primary-box>

        <div class="grid grid-cols-2 gap-4 mt-0">

            <a href="{{ route('games.snake') }}" class="block">
                <x-ui.primary-box class="flex flex-col items-center justify-center py-10 text-center hover:brightness-95 transition-all cursor-pointer h-full">
                    <div class="text-4xl mb-3 select-none">&#128013;</div>
                    <p class="font-bold text-lg">Snake</p>
                    <p class="text-sm text-gray-500 mt-1">Spis mat, voks, overlev</p>
                </x-ui.primary-box>
            </a>

            <a href="{{ route('games.tetris') }}" class="block">
                <x-ui.primary-box class="flex flex-col items-center justify-center py-10 text-center hover:brightness-95 transition-all cursor-pointer h-full">
                    <div class="text-4xl mb-3 select-none">&#129669;</div>
                    <p class="font-bold text-lg">Tetris</p>
                    <p class="text-sm text-gray-500 mt-1">Fyll rader, tøm brettet</p>
                </x-ui.primary-box>
            </a>

        </div>

    </main>
</x-layouts.main>
