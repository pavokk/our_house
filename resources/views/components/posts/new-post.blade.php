<form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                
    @csrf

    {{-- 
    @if (session('success'))
    <p class="text-green-400">{{ session('success') }}</p>
    @endif
    --}}

    <div class="pb-4">
        <!--<textarea name="text" placeholder="What's on your mind?" class="resize-none w-full bg-blue-50"></textarea>-->
        <input id="content" type="hidden" name="content">
        <trix-editor input="content"></trix-editor>
    </div>

    <input id="custom-image-input" type="file" name="image" accept="image/*" class="hidden">
    
    <div>
        <x-ui.primary-button type="button">{{ __('Send') }}</x-main-btn>
    </div>

</form>

@push('styles')

<style>

    trix-editor {
        background: rgb(239 246 255);
        border: none !important;
    }

    span.trix-button-group {
        border: none !important;
    }

    button.trix-button {
        border: none !important;
    }

    trix-editor ul,  trix-editor ol {
        padding-left: 17px;
    }

    trix-editor ul {
        list-style: initial;
    }

    trix-editor ol {
        list-style: numbered;
    }

</style>
    
@endPush

@push('bodyScripts')

<script>
    document.addEventListener('trix-initialize', function () {
        const trixEditor = document.querySelector('trix-editor');

        trixEditor.addEventListener('trix-change', function() {
            console.log("Editor content:", trixEditor.innerHTML);
        });

        const customImageInput = document.getElementById("custom-image-input");

        document.querySelector('.trix-button--icon-attach').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent Trix's default behavior
            console.log('hijacked');
            // customImageInput.click(); // Trigger the custom file input
        });
    });

</script>
    
@endpush