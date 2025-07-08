<x-layouts.main title="{{ $user->name }} sin profil - Skagesundvegen 63">

    <main class="max-w-3xl m-auto mt-5">

        <x-ui.primary-box class="profile-header flex justify-between items-center">

            <div class="pic-and-name flex justify-start items-center gap-4">
                <div class="profile-pic w-16 h-16">
                    @if (isset($user->image))
                        <x-users.profile-picture :imageLocation="asset('storage/' . $user->image->image)" :altText="$user->image->alt" />
                    @else
                        <x-svg.placeholder-profile height="64px" width="50px" color="var(--color-main-dark)" />
                    @endif
                </div>

                <h1 class="text-2xl">{{ $user->name }}s profil</h1>
            </div>

            @auth
                @if (auth()->id() == $user->id)
                    <div class="edit-user w-20">
                        <x-ui.primary-button link="{{ route('user.edit') }}">Rediger</x-main-btn>
                    </div>
                @endif
            @endauth


        </x-ui.primary-box>

        <x-ui.primary-box class="desc-box">

            <p>
                @if (isset($user->description))
                    {{ $user->description }}
                @else
                    Ingenting her...
                @endif
            </p>

        </x-ui.primary-box>

    </main>

</x-layouts.main>
