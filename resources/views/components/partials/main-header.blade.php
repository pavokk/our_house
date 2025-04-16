@php
    // Determine current section based on route
    if (request()->routeIs('index') || request()->routeIs('post.*')) {
        $activeLogo = 'house';
    } elseif (request()->routeIs('gallery.*')) {
        $activeLogo = 'image';
    } elseif (request()->routeIs('calendar.*')) {
        $activeLogo = 'calendar';
    } else {
        $activeLogo = 'house'; // default fallback
    }
@endphp


<section class="bg-compliment h-20">
    <nav class="flex justify-between max-w-3xl w-full h-full m-auto items-center px-5">
        <div class="nav-left relative">
            <!-- Dropdown Trigger Button -->
            <button id="logoDropdownBtn" class="logobox focus:outline-none">
                @if ($activeLogo === 'house')
                    <x-svg.house-logo width="50px" height="50px" />
                @elseif ($activeLogo === 'image')
                    <x-svg.image-logo width="50px" height="50px" />
                @elseif ($activeLogo === 'calendar')
                    <x-svg.calendar-logo width="50px" height="50px" />
                @endif
            </button>

            <!-- Dropdown Menu -->
            <div id="logoDropdown" class="absolute mt-2 left-0 bg-white border rounded shadow-lg hidden z-10">
                <ul class="flex flex-col p-2">
                    <li>
                        <a href="{{ route('index') }}" class="flex items-center gap-2 hover:bg-gray-100 p-2">
                            <x-svg.house-logo width="30px" height="30px" />
                            Posts
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('gallery.index') }}" class="flex items-center gap-2 hover:bg-gray-100 p-2">
                            <x-svg.image-logo width="30px" height="30px" />
                            Gallery
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('calendar.index') }}" class="flex items-center gap-2 hover:bg-gray-100 p-2">
                            <x-svg.calendar-logo width="30px" height="30px" />
                            Calendar
                        </a>
                    </li>
                </ul>
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