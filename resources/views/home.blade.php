<x-app-layout meta-title="Blogku" meta-description="Blogku personal blog">
    <div class="container max-w-5xl mx-auto py-6 px-3">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            {{-- Latest Post --}}
            <div class="col-span-2">
                <h2 class="text-lg sm:text-xl font-bold text-blue-700 uppercase pb-1 border-b-2 border-blue-600 mb-3">
                    Latest Post
                </h2>

                @if ($latestPost)
                <x-post-item :post="$latestPost" />
                @endif
            </div>

            {{-- Popular 3 post --}}
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-blue-700 uppercase pb-1 border-b-2 border-blue-600 mb-3">
                    Popular Posts
                </h2>

                @foreach ($popularPost as $post)
                <div class="grid grid-cols-4 gap-8 mb-4">
                    @if ($post->getImage() !== '/storage/')
                    <a href="{{ route('view', $post) }}" class="pt-1">
                        <img src="{{ $post->getImage() }}" alt="{{ $post->title }}" />
                    </a>
                    @else
                    <a href="{{ route('view', $post) }}" class="pt-1">
                        <img src="/storage/post-image/default.png" alt="default image" />
                    </a>
                    @endif
                    <div class="col-span-3">
                        <a href="{{ route('view', $post) }}">
                            <h3 class="font-semibold text-base">
                                {{ $post->title }}
                            </h3>
                        </a>
                        <div class="text-sm">
                            {{ $post->shortContent(10) }}
                        </div>
                        <a href="{{ route('view', $post) }}" class="text-sm uppercase text-gray-800 hover:text-black">
                            Continue Reading
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Recommended Posts --}}
        <div class="mb-8">
            <h2 class="text-lg sm:text-xl font-bold text-blue-700 uppercase pb-1 border-b-2 border-blue-600 mb-3">
                Recommended Posts
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @foreach ($recommendedPosts as $post)
                <x-post-item :post="$post" :show-author="false" />
                @endforeach
            </div>
        </div>

        {{-- Latest Categories --}}
        @foreach ($categories as $category)
        <div>
            <h2 class="text-lg sm:text-xl font-bold text-blue-700 uppercase pb-1 border-b-2 border-blue-600 mb-3">
                Category {{ $category->name }}
                <a href="{{ route('by-category', $category) }}">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </h2>

            <div class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    @foreach ($category->publishedPosts()->limit(3)->get() as $post)
                    <x-post-item :post="$post" :show-author="false" />
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach

    </div>
</x-app-layout>