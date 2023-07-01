<x-app-layout :meta-title="'Blogku - About us page'" :meta-description="'Project untuk portfolio'">

    <div class="container flex flex-wrap mx-auto lg:px-20 md:px-3">
        <section class="flex flex-col items-center w-full px-3">

            <article class="flex flex-col my-4 shadow">
                <!-- Article Image -->
                @if ($widget && $widget->image)
                <img src="/storage/{{ $widget->image }}">
                @endif
                <div class="flex flex-col justify-start p-6 bg-white">
                    <h1 class="pb-4 text-3xl font-bold hover:text-gray-700">
                        {{ $widget ? $widget->title : '' }}
                    </h1>
                    <div>
                        {!! $widget ? $widget->content : '' !!}
                    </div>
                </div>
            </article>

        </section>
    </div>

</x-app-layout>