<x-layouts.main>
    <main class="max-w-3xl m-auto mt-5">

        @auth
            
            <div class="new-post bg-lightbrown p-5 rounded-lg mb-10">
                
                <x-posts.new-post />

            </div>

        @endauth

        <div class="all-posts flex flex-col gap-5">

            @foreach ($posts as $post)
        
                <x-posts.standard-post :$post :$users />
        
            @endforeach

        </div>


    </main>
</x-layouts.main>