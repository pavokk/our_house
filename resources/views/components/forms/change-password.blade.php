<form action="{{ route('user.update-password') }}" method="post">

    @csrf

    <div class="mt-2">
        <x-forms.input-label for="current_password" :value="__('Nåværende passord')" />
        <x-forms.main-input id="current_password" class="block mt-1 w-full" type="password" name="current_password" required />
        <x-forms.input-error :messages="$errors->get('current_password')" class="mt-2" />
    </div>

    <div class="mt-2">
        <x-forms.input-label for="password" :value="__('Nytt passord')" />
        <x-forms.main-input id="password" class="block mt-1 w-full" type="password" name="password" required />
        <x-forms.input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <div class="mt-2">
        <x-forms.input-label for="password_confirmation" :value="__('Gjenta passord')" />
        <x-forms.main-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
        <x-forms.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="mt-5">
        <x-ui.primary-button type="submit">{{ __('Bytt passord') }}</x-main-btn>
    </div>


</form>