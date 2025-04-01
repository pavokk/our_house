<form action="{{ route('comment.store') }}" method="post" enctype="multipart/form-data">
                
    @csrf

    {{-- 
    @if (session('success'))
    <p class="text-green-400">{{ session('success') }}</p>
    @endif
    --}}

    <div class="pb-4">
        <!--<textarea name="text" placeholder="What's on your mind?" class="resize-none w-full bg-blue-50"></textarea>-->
        <input id="post_id" type="hidden" name="post_id" value="{{ $post->id }}">
        <input id="comment" type="hidden" name="comment">
        <trix-editor input="comment"></trix-editor>
    </div>
    
    <div class="flex gap-4">

        <div class="new-post-button grow bg-main-dark text-center text-main-light rounded-lg h-11">
            <button type="submit" class="h-full w-full cursor-pointer">Go!</button>
        </div>

        <div class="attach-image-button bg-main-dark text-center text-main-light rounded-lg h-11 w-11">
            <button type="button" class="cursor-pointer w-full h-full flex items-center justify-center">
                <x-svg.image-plus width="30px" height="30px" color="var(--color-main-light)" />
            </button>
        </div>

    </div>
    
</form>



@push('styles')

<style>

    trix-editor {
        background: var(--color-main-light);
        border: none !important;
        border-radius: 0.375rem;
        box-shadow: rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.1) 0px 1px 2px -1px;
    }

    span.trix-button-group {
        border: none !important;
    }

    button.trix-button {
        border: none !important;
    }

    span.trix-button-group--file-tools {
        display: none !important;
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