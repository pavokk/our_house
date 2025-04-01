<x-layouts.main :title="$post->title . ' - Skagesundvegen 63'">

    <main class="max-w-3xl m-auto mt-5">

        <x-posts.standard-post :$post :$users :withLinks=false />

        <div class="comment-box my-5">

            <x-posts.post-comments :$post :$users />
            
        </div>
        

        <div class="new-comment bg-compliment p-5 rounded-2xl">

            <x-posts.new-comment :$post />

        </div>

    </main>
    
</x-layouts.main>