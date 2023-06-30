<x-app-layout :meta-title="'Blogku - Posts by category ' . $category->name"
    :meta-description="'By category description'">
    <div class="flex mx-20">
        <!-- Posts Section -->
        <section class="w-full md:w-2/3 flex flex-col items-center px-3">

            @foreach ($posts as $post)
            <x-post-item :post="$post" :show-author="false" />
            @endforeach

            <!-- Pagination -->
            {{ $posts->onEachSide(1)->links() }}

        </section>
        <x-sidebar />
    </div>
</x-app-layout>