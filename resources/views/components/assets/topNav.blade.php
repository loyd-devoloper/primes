<div class="flex justify-between items-center xl:justify-end   px-5 xl:px-10 z-20 fixed top-0 left-0 w-full bg-gradient-to-r from-[#0061ff] to-[#60efff] dark:bg-gradient-to-r dark:from-blue-800 dark:to-indigo-900 min-h-[6rem] max-h-[6rem]">
    <button class="text-white hover:opacity-85 block xl:hidden" x-on:click='aside = !aside'>

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-10 h-10">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5" />
        </svg>

    </button>

    <div class="flex items-center gap-4 z-50">
        <x-filament::icon-button icon="heroicon-o-bell" label="Mark notifications as read"
        size="xl" x-on:click="$dispatch('open-modal', { id: 'database-notifications' })">
            <x-slot  name="badge">
                {{ auth()->user()->unreadNotifications()->count() }}
            </x-slot>
        </x-filament::icon-button>


        {{-- @include('vendor.filament-notifications.components.database.trigger') --}}



        {{-- toggle theme --}}
        <button x-on:click="darkMode =!darkMode; localStorage.setItem('darkMode', darkMode)">
            <div class="h-11 w-11 rounded-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="fill-violet-700 block dark:hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg class="fill-yellow-500 hidden dark:block" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                        fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </div>
        </button>

        {{-- dropdown profile --}}
        <div class="relative  " x-data="{ imageDropdown: false }">


            <button x-on:click='imageDropdown = !imageDropdown'>
                <img src="{{ !!Auth::user()->profile ? asset('storage/' . Auth::user()->profile) : asset('assets/no_image.jpg') }}"
                    alt="Dan Harrin" class="rounded-full min-w-14 max-w-14 min-h-14 max-h-14" />
            </button>
            <div x-cloak x-show='imageDropdown' x-transition
                class="bg-white dark:bg-bgDark dark:border-bgDark grid  p-2 absolute -bottom-70 rounded left-auto right-0 z-50 w-[16rem] border shadow-md">
                <img src="{{ !!Auth::user()->profile ? asset('storage/' . Auth::user()->profile) : asset('assets/no_image.jpg') }}"
                    alt="Dan Harrin" class="rounded-full min-w-32 max-w-32 min-h-32 max-h-32 mx-auto" />
                <h1 class="text-center font-bold dark:text-white">{{ Auth::user()->name }}</h1>
                <h1 class="text-center text-gray-500">{{ Auth::user()->email }}</h1>
                <div class="w-full grid gap-2 mt-4 ">

                    <hr>
                    <x-filament::tabs.item tag='a' href="{{ route('activitylog') }}" icon='heroicon-o-clock'>
                        Activity Log
                    </x-filament::tabs.item>
                    <x-filament::tabs.item tag='a' href="{{ route('system_feedback') }}" icon='heroicon-o-chat-bubble-bottom-center-text'>
                       System Feedback
                    </x-filament::tabs.item>
                    <x-filament::tabs.item tag='a' href="{{ route('auth.logout') }}"
                        icon='heroicon-o-arrow-left-start-on-rectangle'>
                        Logout
                    </x-filament::tabs.item>
                </div>

            </div>
        </div>
    </div>


</div>
