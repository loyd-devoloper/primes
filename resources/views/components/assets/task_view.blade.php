<div class=" w-full">

    <main class="w-full ">
        <h1 class="text-gray-500">Description</h1>
        <article class="px-4  text-sm  py-3 min-w-full  dark:text-white prose leading-none">{!! str($getRecord()->description)->sanitizeHtml() !!} </article>
    </main>
    {{ $getAction('setMaximum') }}
    {{ $getAction('comment') }}

    <section class=" py-8">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-4 dark:text-gray-200">Comments</h2>

            <div class="space-y-4">
               @foreach ($getRecord()?->comments as $comment)

                <div class="bg-white dark:bg-bgDark p-4 rounded-lg shadow">
                    <div class="flex items-center mb-2">

                        @if (!!$comment->employeeInfo?->profile)
                        <x-filament::avatar src="{{ asset('storage/' . $comment->employeeInfo?->profile) }}" alt="{{ $comment->employeeInfo?->name }}"    size="w-10 h-10" class="mr-2"/>

                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 dark:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                          </svg>

                        @endif
                        <div class="dark:text-white">
                            <h3 class="font-semibold">{{$comment->employeeInfo?->name}}</h3>
                            <p class="text-sm text-gray-500"> {{ \Carbon\Carbon::parse($comment->created_at)->diffforHumans() }}</p>
                        </div>
                    </div>
                    <article class="text-gray-700 dark:text-gray-500 prose leading-none">
                        {!! str($comment->comment)->sanitizeHtml() !!}
                    </article>
                    <div class="flex items-center gap-2 mt-2">
                        @if ($comment->id_number == Auth::user()->id_number)
                            {{ ($getAction('editComment')(['id'=>$comment->id])) }}
                            <span class="dark:text-gray-400">&#8226;</span>
                            {{ ($getAction('deleteComment'))(['id'=>$comment->id]) }}
                        @endif





                    </div>
                </div>
               @endforeach


            </div>


        </div>
    </section>
</div>
