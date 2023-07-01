<aside class="flex flex-col items-center w-full px-3 md:w-1/3">

    <div class="flex flex-col w-full p-6 my-4 bg-white shadow">
        <h3 class="mb-3 text-xl font-semibold">
            All Categories
        </h3>
        @foreach ($categories as $category)
        <a href="{{ route('by-category', $category) }}"
            class="block py-2 px-3 rounded {{ request('category')?->slug === $category->slug ? 'bg-blue-800 text-white' : '' }}">
            {{ $category->name }} ({{ $category->total }})
        </a>
        @endforeach
    </div>

    <div class="flex flex-col w-full p-6 my-4 bg-white shadow">
        <p class="pb-5 text-xl font-semibold">
            {{ \App\Models\TextWidget::getTitle('about-us-sidebar') }}
        </p>
        {!! \App\Models\TextWidget::getContent('about-us-sidebar') !!}
        <a href="{{ route('about-us') }}"
            class="flex items-center justify-center w-full px-2 py-3 mt-4 text-sm font-bold text-white uppercase bg-blue-800 rounded hover:bg-blue-700">
            Get to know us
        </a>
    </div>

</aside>