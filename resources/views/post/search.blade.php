<x-app-layout>
    <div class="container flex flex-wrap py-6 mx-auto lg:px-20 md:px-3">
        <!-- Posts Section -->
        <section class="w-full px-3 md:w-2/3">
            <div class="flex flex-col">
                @foreach($posts as $post)
                <div>
                    <a href="{{ route('view', $post) }}">
                        <h2 class="mb-2 text-lg font-bold text-blue-500 sm:text-xl">
                            {!! str_replace(request()->get('q'), '<span
                                class="bg-yellow-400">'.request()->get('q').'</span>', $post->title) !!}
                        </h2>
                    </a>
                    <div>
                        {{$post->shortContent()}}
                    </div>
                </div>
                <hr class="my-4">
                @endforeach
            </div>
            {{ $posts->onEachSide(1)->links() }}
        </section>

        <!-- Sidebar Section -->
        <x-sidebar />
    </div>
</x-app-layout>