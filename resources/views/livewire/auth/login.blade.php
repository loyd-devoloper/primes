@assets
<style>
    .data_privacy{
       border: 1px solid #6a7395;
    }
</style>

@endassets
<div x-data="counter">
    @if (\Carbon\Carbon::parse('01-12-2024')->format('F') == \Carbon\Carbon::now()->format('F'))
    <ul class="lightrope z-50">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>

    </ul>
@endif
    <div class="bg-gradient-to-r from-[#0061ff] to-[#60efff] fixed z-0 top-0 left-0  w-full min-h-[45svh]">

    </div>
    <section class="flex justify-center  pt-[20svh] min-h-[100svh]">

        <form wire:submit.prevent='employee_login'
            class=" z-10 bg-white border w-[90svw] md:w-[34rem] rounded-md  h-fit ">
            <div class="card-body p-5 sm:p-10">
               <div class="flex justify-between">
                   <img src="{{ asset('login.png') }}" class="avatar w-[10rem] md:w-[14rem] " alt="">
                   <img src="{{ asset('assets/r4a.png') }}" class="avatar size-20" alt="">
               </div>
                <h2 class="card-title mt-10 text-2xl leading-4">Please Log In to continue ..</h2>


                <div class="card-actions mt-4">
                    <div class="w-full grid gap-2">
                        <div>
                            <label for="" class="font-semibold">Email</label>

                            <x-filament::input.wrapper class="defaultInputRoundedWithIcon">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-4 h-4 opacity-70 absolute top-4 left-3">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                                <x-filament::input type="text" wire:model='email' style="color: black" />
                            </x-filament::input.wrapper>
                            @error('email')
                                <small class="text-red-500">{{ $message }}</small>
                            @enderror


                        </div>
                        <div>
                            <label for="" class="font-semibold">Password</label>

                            <x-filament::input.wrapper class="defaultInputRoundedWithIcon">


                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-4 h-4 opacity-70 absolute top-4 left-3">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>

                                <x-filament::input type='password' x-ref="password" wire:model="password"
                                    style="color: black" class="grow" placeholder="***************" />

                                <div class="w-4 h-4 opacity-70 absolute top-4 right-3">

                                    <label for="eye" class="cursor-pointer hover:opacity-50">
                                        <svg x-show='eye == false' xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-4 h-4 opacity-70">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        <svg x-show="eye" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-4 h-4 opacity-70">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                        </svg>
                                    </label>
                                    <input type="checkbox" x-model='eye' class="hidden" id="eye">
                                </div>
                            </x-filament::input.wrapper>

                            @error('password')
                                <small class="text-red-500">{{ $message }}</small>
                            @enderror

                        </div>


                        <div  x-data="{data_privacy: false}" >
                            <label class="flex items-center gap-1">
                                <x-filament::input.checkbox wire:model="data_privacy"  class="data_privacy" />

                                <span class="text-xs md:text-md ">DATA PRIVACY NOTICE:  (<span class="font-bold">MUST BE READ</span>)</span>
                                <x-filament::icon-button
                                    icon="heroicon-m-arrow-top-right-on-square"
                                    color="primary"
                                    label="Data Privacy"
                                    size="sm"
                                    x-on:click="data_privacy = !data_privacy"

                                />
                            </label>
                            @error('data_privacy')
                            <small class="text-red-500">{{ $message }}</small>
                            @enderror
                            <p  x-show="data_privacy" x-transition class="text-sm pl-5 text-gray-600 ">Data and Information in this form are intended exclusively for the purpose of this activity. This will be kept by the process owner for the purpose of visitors record. Serving other purposes into intended by the process owner is a violation of Data Privacy Act of 2012. Data subjects voluntarily provided these data and information explicitly consenting the process owner to serve its purpose</p>
                        </div>

{{--                        <div >--}}

{{--                            <div wire:ignore> Let us know you're human--}}
{{--                                <x-turnstile  wire:model="turnstileResponse"  data-action="login" data-size="flexible"   data-expired-callback="expiredCallback"--}}
{{--                                              data-error-callback="errorCallback" /></div>--}}
{{--                            @error('turnstileResponse')--}}
{{--                            <small class="text-red-500">{{ $message }}</small>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

                        <button wire:loading.class='hidden' type="submit"
                            class="flex justify-center items-center gap-2 w-full py-3.5 bg-gradient-to-r from-[#22c1c3] to-[#66bf95] text-white hover:from-[#66bf95]
                        hover:to-[#22c1c3] rounded">Login</button>
                        <div wire:loading class="w-full">
                            <button type="button" disabled
                                class="flex justify-center items-center gap-2 w-full py-4 bg-gradient-to-r from-[#22c1c3] to-[#66bf95] text-white hover:from-[#66bf95]
                                hover:to-[#22c1c3] rounded ">
                                <x-filament::loading-indicator class="h-5 w-5" /></button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </section>

</div>
@script
    <script>
        Alpine.data('counter', () => {
            return {
                eye: true,
                password: null,
                increment() {
                    this.count++
                },
                init() {
                    this.$watch('eye', v => {
                        if (v) {
                            this.$refs.password.type = 'password';
                        } else {
                            this.$refs.password.type = 'text';
                        }
                    })
                }
            }
        })


    </script>
@endscript
