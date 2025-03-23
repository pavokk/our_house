<x-layouts.main title="{{ $user->name }} sin profil - Skagesundvegen 63">

    <main class="max-w-3xl m-auto mt-5">

        <div class="profile-header flex justify-between items-center bg-lightbrown p-5 rounded-lg">
            <h1 class="text-2xl">{{ $user->name }}s profil</h1>
            <div class="buttons w-20">
                @if (auth()->id() == $user->id)
                    <x-ui.primary-button link="{{ route('user.edit') }}">Rediger</x-main-btn>
                @endif
            </div>
        </div>

        <h1>{{ $user->name }}</h1>
        <p>Email: {{ $user->email }}</p>
        <p>Joined: {{ $user->created_at->diffForHumans() }}</p>

    </main>
    
</x-layouts.main>