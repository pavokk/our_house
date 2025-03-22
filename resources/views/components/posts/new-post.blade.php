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
    
    <div class="flex gap-4">

        <div class="new-post-button grow bg-darkbrown text-center ">
            <button type="submit" class="h-full w-full">Go!</button>
        </div>

        <div class="attach-image-button w-16">
            <button type="button">
                <x-svg.image-attach width="30px" height="30px" color="#F2E088" />
            </button>
        </div>

        {{--  
        <x-ui.primary-button type="submit" class="grow-3">{{ __('Send') }}</x-main-btn>
        <x-forms.image-upload />
        --}}
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
    
@endpush