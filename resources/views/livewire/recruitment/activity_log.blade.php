

<main class="overflow-y-auto max-h-[40rem] px-4 ">
    <ol class="relative border-s border-gray-200 dark:border-gray-700 ">
        @foreach ($logs as $log)

        <li class="mb-10 ms-6">

            @if ($log->type == 1)
            <span class="absolute flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-green-900">
                  <svg class="size-4 text-green-800 dark:text-green-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                  </svg>
            </span>
            @elseif($log->type == 2)
            <span class="absolute flex items-center justify-center w-6 h-6 bg-red-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-red-900">
                <svg class="size-4 text-red-800 dark:text-red-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                  </svg>

            </span>
            @elseif($log->type == 10)
            <span class="absolute flex items-center justify-center w-6 h-6 bg-cyan-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-cyan-900">
                <svg  class="size-4 text-cyan-800 dark:text-cyan-300"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                    <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                  </svg>

            </span>
            @endif
            <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $log->activity }}</h3>
            <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ \Carbon\Carbon::parse($log->created_at )->format('Y-m-d h:i:s A')}}</time>
            <p class="text-base font-normal text-gray-500 dark:text-gray-400">{!! $log->message !!}</p>
        </li>
        @endforeach


    </ol>

</main>
