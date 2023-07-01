<x-app-layout :meta-title="'Blogku - Posts by category ' . $category->name"
    :meta-description="'By category description'">
    <div class="flex flex-col md:flex-row lg:mx-20 md:mx-3">
        <!-- Posts Section -->
        <section class="flex flex-col items-center w-full px-3 md:w-2/3">

            @foreach ($posts as $post)
            <x-post-item :post="$post" :show-author="false" />
            @endforeach

            <!-- Pagination -->
            {{ $posts->onEachSide(1)->links() }}

        </section>
        <x-sidebar />
    </div>
</x-app-layout>