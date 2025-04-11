<section class="bg-compliment h-20">

    <nav class="flex justify-between max-w-3xl w-full h-full m-auto items-center px-5">

        <div class="nav-left">
    
            <div class="logobox">
                <a href="{{ route('index') }}">
                    <x-svg.house-logo width="50px" height="50px" />
                </a>
            </div>
    
        </div>
        
        <div class="nav-right">
    
            <div class="authbox">

                @auth

                    <div class="profile w-16 h-16">
                        <a href="{{ route('user.show', auth()->user()->slug) }}">
                            @if (isset(auth()->user()->image))
                                <x-users.profile-picture :imageLocation="asset('storage/' . auth()->user()->image->image)" :altText="auth()->user()->image->alt" />
                            @else
                                <x-svg.placeholder-profile color="var(--color-main-dark)" height="64px" width="50px" />
                            @endif

                        </a>
                    </div>

                @else
                
                    <div class="auth-links flex justify-stretch items-center gap-2 w-64">

                        <div class="login-btn flex-grow">
                            <x-ui.primary-button link="{{ route('user.loginform') }}">Log in</x-ui.primary-button>
                        </div>

                        <div class="register-btn flex-grow">
                            <x-ui.primary-button link="{{ route('user.registerform') }}">Register</x-ui.primary-button>
                        </div>

                    </div>

                @endauth

            </div>
    
        </div>
    
    </nav>

</section>