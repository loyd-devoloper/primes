<div x-data="main({{ $fixMinus }})">
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

        <div class=" z-10 bg-white border w-[90svw] md:w-[34rem] rounded-md  h-fit ">
            <div class="card-body p-5 sm:p-10">
                <img src="{{ asset('login.png') }}" class="avatar w-[14rem]" alt="">
                <h2 class="card-title mt-10 text-2xl leading-4 text-center font-bold">Email Address Verification </h2>
                <p class="text-center text-sm  text-gray-500 pt-2 max-w-[80%] mx-auto !important">Enter the
                    6-digit verification code that was sent to your email address.</p>

                <div class="card-actions mt-4">
                    <form wire:submit.prevent='verify' class="w-full grid  gap-2">
                        <div class="grid grid-cols-6 gap-2 sm:gap-4 w-full sm:w-[90%] mx-auto py-5" x-ref="input">

                            <input type="text" wire:model="num1" x-on:paste="handlePaste($event)"
                                class="p-3 font-extrabold  rounded focus-within:ring-2 ring-1 text-center"
                                pattern="\d*" title="Please enter numbers only" required
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                maxlength="1" x-on:keyup="nextInput">


                            <input type="text" wire:model="num2" x-on:paste="handlePaste($event)"
                                class="p-3 font-extrabold  rounded focus-within:ring-2 ring-1 text-center"
                                pattern="\d*" maxlength="1" required
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                x-on:keyup="nextInput">


                            <input type="text" wire:model="num3"
                                class="p-3 font-extrabold  rounded focus-within:ring-2 ring-1 text-center"
                                x-on:paste="handlePaste($event)" pattern="\d*" maxlength="1" required
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                x-on:keyup="nextInput">


                            <input type="text" wire:model="num4"
                                class="p-3 font-extrabold  rounded focus-within:ring-2 ring-1 text-center"
                                x-on:paste="handlePaste($event)" pattern="\d*" maxlength="1" required
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                x-on:keyup="nextInput">


                            <input type="text" wire:model="num5" x-on:paste="handlePaste($event)"
                                class="p-3 font-extrabold  rounded focus-within:ring-2 ring-1 text-center"
                                pattern="\d*" maxlength="1" required
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                x-on:keyup="nextInput">


                            <input type="text" wire:model="num6" x-on:paste="handlePaste($event)"
                                class="p-3 font-extrabold  rounded focus-within:ring-2 ring-1 text-center"
                                pattern="\d*" required
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1'); "
                                maxlength="1">

                        </div>

                        <div>
                            <p class="text-center text-gray-500 pb-3" x-text="remaining"></p>
                            <button type="button" wire:click="resend" :disabled="disableResend ? true : false"
                                class="underline text-blue-500 font-bold flex items-center gap-1"
                                :class="disableResend ? 'opacity-40 cursor-not-allowed' : ''">
                                Resend
                                <svg wire:loading wire:target="resend" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-4 animate-spin">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>

                            </button>
                            <span></span>
                        </div>
                        <button wire:loading.class='hidden' wire:target="verify" type="submit"
                            class="flex justify-center mt-4 items-center gap-2 w-full py-3.5 bg-gradient-to-r from-[#22c1c3] to-[#66bf95] text-white hover:from-[#66bf95]
                        hover:to-[#22c1c3] rounded"
                            :disabled="disableResend ? false : true"
                            :class="disableResend ? '' : 'opacity-40 cursor-not-allowed'">Verify
                            Account</button>
                        <div wire:loading wire:target="verify" class="w-full">
                            <button type="button" disabled
                                class="flex justify-center items-center gap-2 w-full py-4 bg-gradient-to-r from-[#22c1c3] to-[#66bf95] text-white hover:from-[#66bf95]
                                hover:to-[#22c1c3] rounded ">
                                <x-filament::loading-indicator class="h-5 w-5" /></button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </section>

</div>
@script
    <script>
        Alpine.data('main', (fixMinus) => ({
            open: false,
            expiry: fixMinus,
            remaining: null,
            countdownTime: fixMinus,
            timer: null,
            disableResend: true,
            input: null,
            updateCountdown() {
                var minutes = Math.floor(this.countdownTime / 60);
                var seconds = this.countdownTime % 60;

                // // Pad the seconds with leading zeros if less than 10
                if (seconds < 10) {
                    seconds = '0' + seconds;
                }

                // // Display the countdown
                // document.getElementById('countdown').innerHTML = minutes + ':' + seconds;
                this.remaining = minutes + ':' + seconds;
                // Decrease the countdown time
                this.countdownTime = this.countdownTime - 1;

                var y = this;
                // // Check if the countdown has reached zero
                if (this.countdownTime < 0) {
                    clearInterval(y.timer);
                    this.remaining = 'Your OTP Code has been Expired';
                    y.disableResend = false;
                }
            },
            nextInput() {
                if (!!event.target.value) {
                    this.$focus.within(this.$refs.input).next()
                }

            },
            handlePaste(event) {

                const pasteValue = event.clipboardData.getData('text');
                const otpValue = pasteValue.replace(/\s+/g, '').replace(/\D+/g,
                '');

                this.$refs.input.querySelectorAll('input').forEach((input, index) => {


                    $wire[`num${index + 1}`] = otpValue[index] || '';

                });
            },
            init() {
                var x = this;


                this.timer = setInterval(function() {
                    x.updateCountdown()
                }, 1000);
                this.updateCountdown();

                // Update the countdown every second

            }
        }))
    </script>
@endscript
