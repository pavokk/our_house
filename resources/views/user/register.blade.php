<x-layouts.single>
    <main>

        <div class="register-box">

            <form action="{{ route('user.register') }}" method="post">
                @csrf

                <div>
                    <x-forms.input-label for="name" :value="__('Navn')" />
                    <x-forms.main-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-forms.input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-forms.input-label for="email" :value="__('E-post')" />
                    <x-forms.main-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-forms.input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-forms.input-label for="password" :value="__('Passord')" />

                    <x-forms.main-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />

                    <x-forms.input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-forms.input-label for="password_confirmation" :value="__('Bekreft passord')" />

                    <x-forms.main-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />

                    <x-forms.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('user.loginform') }}">
                        {{ __('Allerede registrert?') }}
                    </a>
        
                    <div class="login-button w-36 ml-5">
                        <x-ui.primary-button type="button">{{ __('Registrer deg') }}</x-main-btn>
                    </div>
                </div>

            </form>

        </div>

    </main>
</x-layouts.single>