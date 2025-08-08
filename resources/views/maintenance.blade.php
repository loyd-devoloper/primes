<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('login.png') }}    " type="image/x-icon">
    <title>{{ $title ?? 'Page Title' }}</title>

    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* width */
        ::-webkit-scrollbar {
            width: 4px;
            height: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

          /* HTML: <div class="loader"></div> */
    .loader {
        width: 35px;

        aspect-ratio: 1;
        --c: no-repeat linear-gradient(#ffffff 0 0);
        background:
            var(--c) 0 0,
            var(--c) 100% 0,
            var(--c) 100% 100%,
            var(--c) 0 100%;
        animation:
            l2-1 2s infinite,
            l2-2 2s infinite;
    }
    .loadingContainer{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    @keyframes l2-1 {
        0% {
            background-size: 0 4px, 4px 0, 0 4px, 4px 0
        }

        12.5% {
            background-size: 100% 4px, 4px 0, 0 4px, 4px 0
        }

        25% {
            background-size: 100% 4px, 4px 100%, 0 4px, 4px 0
        }

        37.5% {
            background-size: 100% 4px, 4px 100%, 100% 4px, 4px 0
        }

        45%,
        55% {
            background-size: 100% 4px, 4px 100%, 100% 4px, 4px 100%
        }

        62.5% {
            background-size: 0 4px, 4px 100%, 100% 4px, 4px 100%
        }

        75% {
            background-size: 0 4px, 4px 0, 100% 4px, 4px 100%
        }

        87.5% {
            background-size: 0 4px, 4px 0, 0 4px, 4px 100%
        }

        100% {
            background-size: 0 4px, 4px 0, 0 4px, 4px 0
        }
    }

    @keyframes l2-2 {

        0%,
        49.9% {
            background-position: 0 0, 100% 0, 100% 100%, 0 100%
        }

        50%,
        100% {
            background-position: 100% 0, 100% 100%, 0 100%, 0 0
        }
    }
</style>
    </style>
</head>

<body x-cloak x-data="{darkMode: localStorage.getItem('darkMode') == 'true'}"  class=" bg-[#fafafa] dark:bg-bgDark  min-h-[100svh]" :class="{ 'dark': darkMode === true }">

    @livewireScripts
    <div class="bg-gray-100">
        <div class="min-h-screen flex flex-col justify-center items-center">
          <img src="https://www.svgrepo.com/show/426192/cogs-settings.svg" alt="Logo" class="mb-8 h-40">
          <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-center text-gray-700 mb-4">Site is under maintenance</h1>
          <p class="text-center text-gray-500 text-lg md:text-xl lg:text-2xl mb-8">We're working hard to improve the user experience. Stay tuned!</p>
        </div>
      </div>
    @filamentScripts
    @vite('resources/js/app.js')

</body>

</html>
