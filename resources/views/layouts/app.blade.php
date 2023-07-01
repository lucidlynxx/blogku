<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metaTitle ?: 'Blogku' }}</title>
    <meta name="author" content="Blogku">
    <meta name="description" content="{{ $metaDescription }}">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
    </style>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
        integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>

    @livewireStyles
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-family-karla">

    <!-- Top Bar Nav -->
    <nav class="w-full py-5 bg-blue-800 shadow">
        <div class="container flex flex-wrap items-center justify-between w-full mx-auto lg:px-28">

            <nav>
                <ul class="flex items-center justify-between text-sm font-bold text-white no-underline uppercase">
                    <li><a class="px-4 hover:text-gray-200 hover:underline" href="{{ route('home') }}">Home</a></li>
                    <li><a class="px-4 hover:text-gray-200 hover:underline" href="{{ route('about-us') }}">About us</a>
                    </li>
                </ul>
            </nav>

            <div class="flex items-center text-sm text-white no-underline">
                @auth
                <div x-data="{
                    open: false,
                    toggle() {
                        if (this.open) {
                            return this.close()
                        }
        
                        this.$refs.button.focus()
        
                        this.open = true
                    },
                    close(focusAfter) {
                        if (! this.open) return
        
                        this.open = false
        
                        focusAfter && focusAfter.focus()
                    }
                }" x-on:keydown.escape.prevent.stop="close($refs.button)"
                    x-on:focusin.window="! $refs.panel.contains($event.target) && close()" x-id="['dropdown-button']"
                    class="relative">
                    <!-- button -->
                    <button x-ref="button" x-on:click="toggle()" :aria-expanded="open"
                        :aria-controls="$id('dropdown-button')" type="button"
                        class="inline-flex px-4 font-bold uppercase hover:text-gray-200 hover:underline">
                        {{ Auth::user()->name }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 ml-2 transition-all"
                            x-bind:class="{'rotate-90': open}">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>

                    <!-- Panel -->
                    <div x-ref="panel" x-show="open" x-transition.origin.top.left
                        x-on:click.outside="close($refs.button)" :id="$id('dropdown-button')" style="display: none;"
                        class="absolute w-40 mt-2 bg-white rounded-md shadow-md right-3">
                        <a href="{{ route('filament.pages.my-profile') }}" target="_blank"
                            class="flex items-center w-full gap-2 px-4 py-2 text-sm text-left first-of-type:rounded-t-md last-of-type:rounded-b-md hover:bg-gray-50 disabled:text-gray-500">
                            <span class="font-bold text-black uppercase">Profile</span>
                        </a>
                        <form method="POST" action="{{ route('filament.auth.logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full gap-2 px-4 py-2 text-sm text-left first-of-type:rounded-t-md last-of-type:rounded-b-md hover:bg-gray-50 disabled:text-gray-500">
                                <span class="font-bold text-black uppercase">Log out</span>
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a class="px-4 font-bold uppercase hover:text-gray-200 hover:underline"
                    href="{{ route('filament.auth.login') }}" target="_blank">
                    Login
                </a>
                <a class="px-4 pl-6 font-bold uppercase hover:text-gray-200 hover:underline"
                    href="{{ route('register') }}" target="_blank">
                    Register
                </a>
                @endauth
            </div>
        </div>

    </nav>

    <!-- Text Header -->
    <header class="container w-full mx-auto">
        <div class="flex flex-col items-center py-12">
            <a class="text-5xl font-bold text-gray-800 uppercase hover:text-gray-700" href="{{ route('home') }}">
                BlogKu
            </a>
            <p class="text-lg text-gray-600">
                {{ \App\Models\TextWidget::getTitle('header') }}
            </p>
        </div>
    </header>

    <!-- Topic Nav -->
    <nav class="w-full py-4 bg-gray-100 border-t border-b" x-data="{ open: false }">
        <div class="block sm:hidden">
            <a href="#" class="flex items-center justify-center text-base font-bold text-center uppercase md:hidden"
                @click="open = !open">
                Topics <i :class="open ? 'fa-chevron-down': 'fa-chevron-up'" class="ml-2 fas"></i>
            </a>
        </div>
        <div :class="open ? 'block': 'hidden'" class="flex-grow w-full sm:flex sm:items-center sm:w-auto">
            <div
                class="container flex flex-col items-center justify-center w-full px-6 py-2 mx-auto mt-0 text-sm font-bold uppercase sm:flex-row">
                @foreach ($categories as $category)
                <a href="{{ route('by-category', $category) }}"
                    class="px-4 py-2 mx-2 rounded hover:bg-blue-800 hover:text-white">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
    </nav>


    <div class="container py-6 mx-auto">

        @if (!request()->routeIs('about-us'))
        <div class="max-w-5xl p-3 mx-auto">
            <form method="GET" action="{{ route('search') }}">
                <label for="default-search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input name="q" value="{{ request()->get('q') }}" type="search"
                        class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-800 focus:border-blue-800 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-800 dark:focus:border-blue-800"
                        placeholder="search anything..">
                    <button type="submit"
                        class="text-white absolute right-2.5 bottom-2.5 bg-blue-800 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                </div>
            </form>
        </div>
        @endif

        {{ $slot }}

    </div>

    <footer class="w-full bg-white border-t">
        <div class="container flex flex-col items-center w-full mx-auto">
            <div class="py-6">&copy; {{ date('Y') }} Dzaky Syahrizal. All Rights Reserved.</div>
        </div>
    </footer>

    @livewireScripts
</body>

</html>