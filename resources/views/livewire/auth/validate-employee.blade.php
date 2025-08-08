<div>
    {{-- <object data="https://192.168.1.31/personnel/public/uploaded_certificate/No_files_Upload.pdf" type="application/pdf" width="100%" height="500px">
        <p>Unable to display PDF file. <a href="https://192.168.1.31/personnel/public/uploaded_certificate/No_files_Upload.pdf">Download</a> instead.</p>
      </object> --}}
    <section class="flex justify-center items-center min-h-[100svh]">

        {{-- validate form --}}
        <form wire:ignore wire:submit.prevent='validateUser' class=" border w-[90svw] md:w-[34rem] border-t-4 border-t-blue-600  ">
            <div class="card-body p-5 sm:p-10">
                <img src="{{ asset('login.png') }}" class="avatar w-[10rem] sm:w-[14rem]" alt="">
                <h2 class="card-title mt-10 text-2xl leading-4">Hello {{ $name }}!</h2>
                <p class="text-gray-500 font-light mt-2">Please enter ID Number to continue.</p>

                <div class="card-actions mt-4">
                    <div class="w-full">
                        {{-- input --}}
                        <x-filament::input.wrapper class="defaultInput">
                            <x-filament::input type="text" wire:model="user_no"  placeholder="1234567" />
                        </x-filament::input.wrapper>
                        @if (Session::has('no_record'))
                            <small class="text-red-500"> No Record(s) Found </small>
                        @endif
                    </div>
                    <button type="submit" wire:loading.class="hidden"
                        class="bg-gradient-to-r from-[#22c1c3] to-[#66bf95] text-white py-3 px-3 w-full rounded mt-3 hover:from-[#66bf95]
                        hover:to-[#22c1c3]">Validate</button>
                    {{-- loading --}}
                    <div wire:loading class="w-full">
                        <button disabled
                            class="bg-gradient-to-r from-[#22c1c3] to-[#66bf95] text-white  py-3.5 px-3 w-full rounded mt-3 flex justify-center items-center  ">
                            <x-filament::loading-indicator class="h-5 w-5"  /></button>
                    </div>


                </div>
            </div>
        </form>
    </section>
</div>
