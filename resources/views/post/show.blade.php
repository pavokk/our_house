<x-layouts.main :title="$post->title . ' - Skagesundvegen 63'">

    <main class="max-w-3xl m-auto mt-5">

        <x-ui.primary-box class="single-post">

            <x-posts.standard-post :$post :withLinks=false />

        </x-ui.primary-box>

        <x-ui.primary-box class="post-comments">

            <x-posts.post-comments :$post />
            
        </x-ui.primary-box>
        
        @auth
            
            <x-ui.primary-box class="new-comment">

                <x-posts.new-comment :$post />

            </x-ui.primary-box>

        @endauth

    </main>
    
</x-layouts.main>