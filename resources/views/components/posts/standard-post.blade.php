@props([
    'withLinks' => true,
    'post',
    'users'
    ])

    <x-posts.post-user :$users :$post />

    <x-posts.post-content :$users :$post :$withLinks />

    <x-posts.post-buttons :$post :$withLinks />


@pushOnce('styles')

<style>
    div.post-text ol, div.post-text ul {
        list-style: initial;
        padding-left: 18px;
    }

    div.post-text ul {
        list-style: initial;
    }

    div.post-text ol {
        list-style: numbered;
    }

    div.post-text pre {
        @apply whitespace-pre-wrap;
        display: inline;
        font-family: monospace;
        background-color: #f7f7f7;
        border: 1px solid black;
        border-radius: 8px;
    }

    div.post-text blockquote {
        margin: 1rem 0;
        padding: 0.5rem 1rem;
        border-left: 4px solid rgb(147 197 253);
        font-style: italic;
    }
</style>
    
@endPushOnce

@pushOnce('bodyScripts')

<script>

function toggleLike(element, postId) {
    let likeButton = element.closest('.like-button');
    let likeCountElement = likeButton.querySelector('.like-count');
    let likeIcon = likeButton.querySelector('svg path'); // Select the heart path inside SVG
    let likeCount = parseInt(likeCountElement.textContent);
    let isLiked = likeIcon.getAttribute("fill") !== "none"; // Check if the heart is filled

    axios({
        method: isLiked ? 'delete' : 'post',
        url: isLiked ? `/likes/${postId}` : '/likes',
        data: { post_id: postId },
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => {
        if (isLiked) {
            likeCount--;
            likeIcon.setAttribute("fill", "none"); // Remove fill when unliked
        } else {
            likeCount++;
            likeIcon.setAttribute("fill", "var(--color-main-dark)"); // Fill the heart when liked
        }
        likeCountElement.textContent = likeCount;
    })
    .catch(error => console.error("Error:", error));
}

</script>

@endPushOnce