<x-app-layout :meta-title="'Blogku - About us page'" :meta-description="'Project untuk portfolio'">

    <div class="container mx-auto px-24 flex flex-wrap">
        <section class="w-full flex flex-col items-center px-3">

            <article class="flex flex-col shadow my-4">
                <!-- Article Image -->
                @if ($widget && $widget->image)
                <img src="/storage/{{ $widget->image }}">
                @endif
                <div class="bg-white flex flex-col justify-start p-6">
                    <h1 class="text-3xl font-bold hover:text-gray-700 pb-4">
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