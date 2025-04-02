<x-layouts.main title="Rediger din profil - Skagesundvegen 63">

    <main class="max-w-3xl m-auto mt-5">

        <div class="my-2">
            <a href="{{ route('user.show', auth()->user()->slug) }}">Tilbake</a>
        </div>

        <x-ui.primary-box class="change-profile-picture">

            <x-forms.change-profile-picture />

        </x-ui.primary-box>

        <x-ui.primary-box class="change-details">

            <div>
                <h2 class="text-2xl mb-5">Detaljer</h2>
            </div>

            <x-forms.change-profile-details :$user />

        </x-ui.primary-box>

        <x-ui.primary-box class="change-password">

            <div>
                <h2 class="text-2xl mb-5">Bytt passord</h2>
            </div>

            <p class="mb-5">Passord skal være minimum 8 tegn, ellers ingen andre regler.</p>

            <x-forms.change-password />

        </x-ui.primary-box>

        <x-ui.primary-box class="delete-user">

            <div>
                <h2 class="text-2xl mb-5">Slett din konto</h2>
            </div>

            <p class="mb-5">Sletting av din konto kan ikke reverseres, innlegg og kommentarer du har skrevet forsvinner med kontoen.</p>

            <x-ui.primary-button :link="route('user.confirm-delete')" bg="bg-red-500">Slett konto</x-ui.primary-button>

        </x-ui.primary-box>

    </main>

</x-layouts.main>