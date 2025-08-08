<div>
    <div class="bg-gradient-to-r from-[#0061ff] to-[#60efff] fixed z-0 top-0 left-0  w-full min-h-[45svh]">

    </div>
    <section class="flex justify-center pt-[10svh] xl:pt-[20svh] min-h-[100svh] p-2 ">

        <div class=" z-10 bg-[#ffffff] border w-fit xl:w-[60rem] rounded  h-fit">
            <div class=" p-4 xl:p-10 flex flex-col xl:flex-row gap-3">
                {{-- employee profile --}}

                <div class="flex flex-col  items-center gap-1 ">
                    <img src="{{ !!$user?->profile ? asset('storage/'.$user?->profile) : asset('assets/no_image.jpg') }}"
                        class="min-w-[15rem] max-w-[15rem] min-h-[15rem] max-h-[15rem] rounded-full border-2 border-black" alt="">
                    <h2 class=" font-semibold">{{ $user->name }}</h2>
                    {{-- <p class="text-gray-500">{{ $user->email }}</p> --}}
                </div>


                {{-- Basic information --}}
                <div class="px-2 xl:px-10 w-full">
                    <h2 class="text-2xl font-bold">Basic Information</h2>

                    <div class="grid gap-2 p-3">
                        <div class="grid  gap-5">

                            {{-- birth date input --}}
                            {{-- <div>
                                <label for="" class="font-semibold">Birth Date</label>
                                <x-filament::input.wrapper class="defaultInputRoundedWithIcon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-4 h-4 opacity-70 absolute top-4 left-3">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                    </svg>

                                    <x-filament::input type="text" value="{{ $userInfo ?  \Illuminate\Support\Facades\Crypt::decryptString($userInfo->birth_date) : '' }}" readonly />
                                </x-filament::input.wrapper>

                            </div> --}}
                            {{-- gender input --}}
                            <div>
                                <label for="" class="font-semibold">Gender</label>
                                <x-filament::input.wrapper class="defaultInputRoundedWithIcon">
                                    <svg fill="#000000" class="w-4 h-4 opacity-70 absolute top-4 left-3"
                                        viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M211.9209,23.21582c-.02246-.11328-.06519-.21777-.09693-.32715a3.96647,3.96647,0,0,0-.13012-.41943,3.94126,3.94126,0,0,0-.19385-.36817c-.05811-.10693-.10522-.21777-.17383-.31982a3.99291,3.99291,0,0,0-.49316-.604l-.0044-.00537h0a4.00638,4.00638,0,0,0-.61035-.49854c-.09814-.06543-.20434-.11035-.30664-.1665a2.33028,2.33028,0,0,0-.78784-.32715c-.11377-.03321-.22266-.07715-.34033-.10059A3.99092,3.99092,0,0,0,208,20H168a4,4,0,0,0,0,8h30.34326L164.38574,61.95752A63.97641,63.97641,0,1,0,116,171.8623V200H88a4,4,0,0,0,0,8h28v24a4,4,0,0,0,8,0V208h28a4,4,0,0,0,0-8H124V171.8623A63.94175,63.94175,0,0,0,169.79688,67.85986L204,33.65674V64a4,4,0,0,0,8,0V24.00146A4.03032,4.03032,0,0,0,211.9209,23.21582ZM120,164a56,56,0,1,1,56-56A56.06322,56.06322,0,0,1,120,164Z" />
                                    </svg>

                                    <x-filament::input type="text" readonly  value="{{ $userInfo?->sex }}"/>
                                </x-filament::input.wrapper>


                            </div>
                        </div>

                        {{-- citizenship  input --}}
                        <div>
                            <label for="" class="font-semibold">Citizenship</label>
                            <x-filament::input.wrapper class="defaultInputRoundedWithIcon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    strokeWidth={1.5} stroke="currentColor"
                                    class="w-4 h-4 opacity-70 absolute top-4 left-3">
                                    <path strokeLinecap="round" strokeLinejoin="round"
                                        d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                                </svg>

                                <x-filament::input type="text" readonly value="{{ $userInfo?->citizenship }}" />
                            </x-filament::input.wrapper>

                        </div>

                        {{-- residential  address   input --}}
                        {{-- <div>
                            <label for="" class="font-semibold"> Residential Address </label>
                            <x-filament::input.wrapper class="defaultInputRoundedWithIcon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-4 h-4 opacity-70 absolute top-4 left-3">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>

                                <x-filament::input type="text" readonly  value="{{ !!$residential ? Illuminate\Support\Facades\Crypt::decryptString($residential?->street).', '.Illuminate\Support\Facades\Crypt::decryptString($residential?->city).', '.Illuminate\Support\Facades\Crypt::decryptString($residential?->province) :'' }}"/>
                            </x-filament::input.wrapper>

                        </div> --}}
                        {{--  Permanent Address  input --}}
                        {{-- <div>
                            <label for="" class="font-semibold"> Permanent Address </label>
                            <x-filament::input.wrapper class="defaultInputRoundedWithIcon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-4 h-4 opacity-70 absolute top-4 left-3">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>

                                <x-filament::input type="text" readonly value="{{ !!$permanent ? Illuminate\Support\Facades\Crypt::decryptString($permanent?->street).', '.Illuminate\Support\Facades\Crypt::decryptString($permanent?->city).', '.Illuminate\Support\Facades\Crypt::decryptString($permanent?->province) :'' }}"/>
                            </x-filament::input.wrapper>
                        </div> --}}

                        <div class="flex justify-end">
                            <a href="{{ route('auth.login') }}"
                                class="flex justify-center items-center gap-2 w-full py-3 bg-gradient-to-r from-[#22c1c3] to-[#66bf95] text-white hover:from-[#66bf95]
                                 hover:to-[#22c1c3] rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>

                                More Information</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
