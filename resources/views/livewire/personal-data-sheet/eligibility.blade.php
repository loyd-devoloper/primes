<x-assets.admin_layout target="storeFamilyInfo , callMountedAction">
    <x-slot name="modal">
        <div x-cloak class="z-50">
            <x-filament-actions::modals class="z-50" />
        </div>
    </x-slot>

    <div >

        <x-bread-crumb class="py-10" :list="[
            [
                'link' => null,
                'name' => 'Personal Data Sheet',
            ],
            [
                'link' => null,
                'name' => 'Eligibility',
            ],
        ]" />
        {{-- children container  --}}
        <div >

            <x-filament::section>
                <x-slot name="heading">
                   <div class="justify-between flex items-center">
                    <h2 class="pb-6 font-bold">Eligibility</h2>

                    {{ $this->modalFormAction }}

                   </div>
                </x-slot>


                <div class="grid lg:grid-cols-3 xl:grid-cols-4 gap-2">
                    @forelse ($licenses as $license)
                        <x-filament::section>
                            @if ($license->type == 'Civil Service')
                                <div class="w-full flex justify-center">
                                    <img src="{{ asset('license_image/civil_service.png') }}"
                                    class="w-40 h-40 rounded-full  border-2 " alt="">
                                </div>
                            @elseif($license->type == 'Professional Regulation Commission')
                            <div class="w-full flex justify-center">
                                <img src="{{ asset('license_image/prc.png') }}"
                                    class="w-40 h-40 rounded-full mx-auto border-2 " alt="">
                            </div>

                            @elseif($license->type == "LTO - Driver's License")
                            <div class="w-full flex justify-center">
                                <img src="{{ asset('license_image/lto.png') }}"
                                class="w-40 h-40 rounded-full mx-auto border-2 " alt="">
                            </div>


                            @elseif($license->type == 'Supreme Court')
                            <div class="w-full flex justify-center">
                                <img src="{{ asset('license_image/supreme_court.png') }}"
                                class="w-40 h-40 rounded-full mx-auto border-2 " alt="">
                            </div>

                            @elseif($license->type == 'Other License')
                            <div class="w-full flex justify-center">
                                <img src="{{ asset('license_image/republica.png') }}"
                                class="w-40 h-40 rounded-full mx-auto border-2 " alt="">
                            </div>

                            @endif
                            <div class="space-y-3 mt-2">
                                <x-filament::input.wrapper prefix-icon="heroicon-o-trophy">
                                    <x-filament::input type="text" value="{{ $license->license_title }}"
                                        readonly />
                                </x-filament::input.wrapper>
                                <x-filament::input.wrapper prefix-icon="heroicon-o-star">
                                    <x-filament::input type="text" value="{{ $license->rating }}" readonly />
                                </x-filament::input.wrapper>
                                <x-filament::input.wrapper prefix-icon="heroicon-o-calendar-days">
                                    <x-filament::input type="text" value="{{ $license->date_examination }}"
                                        readonly />
                                </x-filament::input.wrapper>
                                <x-filament::input.wrapper prefix-icon="heroicon-o-map-pin">
                                    <x-filament::input type="text" value="{{ $license->place_examination }}"
                                        readonly />
                                </x-filament::input.wrapper>
                                <x-filament::input.wrapper prefix-icon="heroicon-o-calculator">
                                    <x-filament::input type="text" value="{{ $license->license_number }}"
                                        readonly />
                                </x-filament::input.wrapper>
                                <x-filament::input.wrapper prefix-icon="heroicon-o-shield-exclamation">
                                    <x-filament::input type="text" value="{{ $license->date_validity }}"
                                        readonly />
                                </x-filament::input.wrapper>
                                <div class="flex gap-2 justify-end">
                                    {{ ($this->buttonAction)(['license_id' => $license->id]) }}
                                    {{ ($this->confirmationModalAction)(['license_id' => $license->id]) }}
                                </div>
                            </div>
                        </x-filament::section>
                        @empty

                        <span class="dark:text-white"> No Eligibility Found!</span>
                        @endforelse
                </div>
                {{-- Content --}}
            </x-filament::section>
        </div>
    </div>

</x-assets.admin_layout>

@script
    <script>
        Alpine.data('skillDisplay', () => ({
            aside: true,

        }));
    </script>
@endscript
