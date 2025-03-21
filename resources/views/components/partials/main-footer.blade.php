<footer class="mt-10">

    <div class="footer-box text-center">
        @auth
            <form method="POST" action="{{ route('user.logout') }}">
                @csrf
                <a :href="route('user.logout')" onclick="event.preventDefault();this.closest('form').submit();" class="cursor-pointer">{{ __('Logg ut') }}</a>
            </form>
        @endauth
    </div>

</footer>