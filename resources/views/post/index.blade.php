<x-layouts.main title="Skagesundvegen 63">
    <main class="max-w-3xl m-auto mt-5">

        @auth
            
            <x-ui.primary-box class="new-post">
                
                <x-posts.new-post />
            
            </x-ui.primary-box>

        @endauth

        <div class="all-posts flex flex-col gap-5">

            @foreach ($posts as $post)

                <x-ui.primary-box class="single-post">
        
                    <x-posts.standard-post :$post :$users />

                </x-ui.primary-box>
        
            @endforeach

        </div>


    </main>
</x-layouts.main>