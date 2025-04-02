<x-layouts.main title="Sletting av konto - Skagesundvegen 63">

    <main class="max-w-3xl m-auto mt-5">

        <x-ui.primary-box class="change-profile-picture">
            <div>
                <h2 class="text-2xl mb-5">Er du sikker?</h2>
            </div>

            <form action="{{ route('user.delete') }}" method="post">

                @csrf
                @method('DELETE')

                <x-ui.primary-button type="submit" bg="bg-red-500">Helt sikker, slett kontoen min</x-ui.primary-button>

            </form>

        </x-ui.primary-box>

    </main>

</x-layouts.main>