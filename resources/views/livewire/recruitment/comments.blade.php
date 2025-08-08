<ul class="grid gap-2 w-auto overflow-hidden ">
    @foreach ($comments as $comment)
        <div class="text-xs bg-gray-100 dark:bg-bgDark p-2 rounded-md flex justify-between">
            <div class="flex gap-2">
                @if (!!$comment->employeeInfo?->profile)
                <x-filament::avatar src="{{ asset('storage/' . $comment->employeeInfo?->profile) }}" alt="{{ $comment->employeeInfo?->name }}" />
                @else
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 dark:text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                  </svg>

                @endif

                <div class="grid dark:text-white">

                    <p class="font-bold">{{$comment->employeeInfo?->name}}</p>
                    <p class="text-gray-500">{{\Carbon\Carbon::parse($comment->created_at)->format('m-d-y h:m:s A')}}</p>
                    <p class="px-2 break-all whitespace-break-spaces break-words ">{{ $comment->comment }}</pc>
                </div>

            </div>
           @if (Auth::user()->id_number == $comment->id_number)
           <button type="button" class="text-red-500"
           wire:click="deleteComment({{ $comment->id }},{{ $record->id }})">

           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
               stroke="currentColor" class="size-4">
               <path stroke-linecap="round" stroke-linejoin="round"
                   d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
           </svg>

       </button>
           @endif
        </div>
    @endforeach

</ul>
