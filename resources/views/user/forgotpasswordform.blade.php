<x-layouts.single title="Logg inn - Skagesundvegen 63">
    
    <!-- Session Status -->
    {{--<x-auth-session-status class="mb-4" :status="session('status')" />--}}

    <form method="POST" action="{{ route('user.login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-forms.input-label for="email" :value="__('Email')" />
            <x-forms.main-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-forms.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-forms.input-label for="password" :value="__('Password')" />

            <x-forms.main-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-forms.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('user.forgotpasswordform'))
                <a class="underline text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('user.forgotpasswordform') }}">
                    {{ __('Glemt passord?') }}
                </a>
            @endif
            
            <div class="login-button w-36 ml-5">
                <x-ui.primary-button type="submit">{{ __('Logg inn') }}</x-main-btn>
            </div>
        </div>
    </form>

</x-layouts.single>