<form action="{{ route('user.update-picture') }}" method="post" enctype="multipart/form-data">

    @csrf

    <x-forms.main-input id="file" class="mt-1 w-full hidden" type="file" name="file" required accept="image/png, image/jpeg, image/webp, image/gif" />

    <div class="w-2xl m-auto">

        <div class="profile-picture-show w-64 h-64 m-auto mb-5 group">
            <button type="button" class="w-full h-full relative overflow-hidden cursor-pointer">
                <img id="previewImage" class="hidden w-full h-full object-cover rounded-full" />
                @if (isset(auth()->user()->image))
                    <x-users.profile-picture :imageLocation="asset('storage/' . auth()->user()->image->image)" :altText="auth()->user()->image->alt" />
                @else
                    <x-svg.placeholder-profile color="var(--color-main-dark)" height="100%" width="100%" />
                @endif
                <div class="absolute h-full w-full bg-black/50 flex items-center justify-center -bottom-0 opacity-0 group-hover:opacity-100 transition-all duration-200 rounded-full">
                    <div class="click-image-txt text-main-light text-xl">Velg bilde</div>
                </div>
            </button>
        </div>

    </div>

    <div class="submit-profilepic">
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
    const fileInput = document.querySelector('#file');
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