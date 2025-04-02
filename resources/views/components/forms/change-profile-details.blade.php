<form action="{{ route('user.update') }}" method="post">

    @csrf

    <div class="mt-2">
        <x-forms.input-label for="name" :value="__('Navn')" />
        <x-forms.main-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$user->name" required />
        <x-forms.input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="mt-2">
        <x-forms.input-label for="email" :value="__('E-post')" />
        <x-forms.main-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$user->email" required />
        <x-forms.input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div class="mt-2">
        <x-forms.input-label for="description" :value="__('Kort tekst om deg selv')" />
        <x-forms.main-input id="description" class="block mt-1 w-full" type="text" name="description" :value="$user->description" />
        <x-forms.input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div class="mt-5">
        <x-ui.primary-button type="submit">{{ __('Lagre detaljer') }}</x-main-btn>
    </div>


</form>