<div class="flex gap-4 mt-6 justify-end">
    <button wire:click='upvoteDownvote()'
        class="flex items-center gap-2 hover:text-blue-800 transition-all {{ $hasUpvote ? 'text-blue-700' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z" />
        </svg>
        {{ $upvotes }}
    </button>
    <button wire:click='upvoteDownvote(false)'
        class="flex items-center gap-2 hover:text-blue-800 transition-all {{ $hasUpvote === false ? 'text-blue-700' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
        </svg>
        {{ $downvotes }}
    </button>
</div>