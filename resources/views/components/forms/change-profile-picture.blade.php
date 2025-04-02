<form action="{{ route('profile.update-picture') }}" method="post">

    @csrf

    <x-forms.main-input id="profile_picture" class="mt-1 w-full hidden" type="file" name="profile_picture" required accept="image/png, image/jpeg, image/webp, image/gif" />

    <div class="w-2xl m-auto">

        <div class="profile-picture-show w-64 h-64 m-auto mb-5">
            <button>
                <img id="previewImage" class="hidden w-full h-full object-cover" />
                @if (isset(auth()->user()->image))
                    <x-users.profile-picture imageLocation={{ asset('storage/' . auth()->user()->image) }} altText="{{auth()->user()->name}}s profilbilde" />
                @else
                    <x-svg.placeholder-profile color="var(--color-main-dark)" height="100%" width="100%" />
                @endif

            </button>
        </div>

    </div>

    <div class="login-button">
        <x-ui.primary-button type="submit">{{ __('Lagre profilbilde') }}</x-main-btn>
    </div>


</form>

@push('styles')

<style>
    /* Styles? */
</style>
    
@endpush

@push('bodyScripts')

<script>
    const profileButton = document.querySelector('.profile-picture-show button');
    const fileInput = document.querySelector('#profile_picture');
    const previewImage = document.querySelector('#previewImage');

    profileButton.addEventListener("click", function (event) {
        event.preventDefault();
        fileInput.click();
    });

    fileInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            let file = this.files[0];

            let reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewImage.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
    
@endpush