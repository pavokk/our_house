<x-layouts.main :title="$post->title . ' - Skagesundvegen 63'">

    <main class="max-w-3xl m-auto mt-5">
        <x-posts.standard-post :$post :$users :withLinks=false />
    </main>
    
</x-layouts.main>