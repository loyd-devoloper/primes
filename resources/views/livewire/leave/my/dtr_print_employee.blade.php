@assets
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="{{ asset('canva.js') }}"></script>
@endassets
<div>

    <main x-data="skillDisplay">
        {{--        <button  class="bg-gray-500 px-6 py-2">Generate PDF</button> --}}
        <section>
            <div>

                <x-filament::icon-button icon="heroicon-m-printer" label="Print" color="secondary" type="button"
                    x-on:click="generateMe()" />
                {{-- Content --}}
                <div x-data="{ model: @js($dtrData) }" class="max-w-[15rem] px-1 mb-2">
                    {{ $this->form }}
                </div>
                <div :id="'table'" class="block w-fit  overflow-x-auto   mx-auto text-xs relative ">


                    <div class=" ">
                        {{-- <img src="{{ $qrcode }}" id="qr_code_b" class="absolute  w-[3rem] top-0 right-2" alt=""> --}}
                        <img src="{{ asset('/assets/dtr_image.png') }}" class="max-w-[29rem] " alt="">
                        <p class="py-2 "><i>Civil Service Form No. 48</i></p>
                        <p class="text-center leading-none pt-4 pb-1 font-bold text-lg">DAILY TIME RECORD</p>
                        <p class="text-center ">-----o0o-----</p>
                        <p class="border-b border-black text-center font-bold mt-4">
                            {{ explode('--', $dtrData['user_name'])[1] }}</p>
                        <h6 class="text-center text-xs">(Name)</h6>
                        <div class="grid grid-cols-5 pt-5">
                            <div class="col-span-2 px-3">
                                <p class="text-center">For the month of</p>
                                <p class="text-center py-1">Official hours</p>
                                <p class="text-center">for arrival and departure</p>
                            </div>
                            <div class="col-span-3">
                                <p class="border-b border-black text-center font-bold uppercase">
                                    {{ \Carbon\Carbon::parse($dtrData['date'])->format('F Y') }}
                                </p>
                                <div class="grid grid-cols-2 py-1">
                                    <p class="text-center">Regular days</p>
                                    <div class="border-b border-black"></div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <p class="text-center">Saturdays</p>
                                    <div class="border-b border-black"></div>
                                </div>
                            </div>
                        </div>
                        {{-- Content --}}
                        <div x-data="{ employee: @js($dtrData) }" class=" max-w-[29rem]  h-full pt-10">
                            <table class="border-collapse w-full ">
                                <tr class="">
                                    <td class="border border-black border-solid px-2.5 text-center" rowspan="2">Days
                                    </td>
                                    <td class="border-y border-r border-black border-solid px-2.5 text-center"
                                        colspan="2">
                                        A.M.</td>
                                    <td class="border-y border-r border-black border-solid px-2.5 text-center"
                                        colspan="2">
                                        P.M.</td>
                                    <td class="border-y border-r border-black border-solid px-2.5 text-center"
                                        colspan="2">
                                        UNDERTIME</td>
                                </tr>
                                <tr class="">
                                    <td class="border-b border-r border-black border-solid px-2.5 text-center">Arrival
                                    </td>
                                    <td class="border-b border-r border-black border-solid px-2.5 text-center">Departure
                                    </td>
                                    <td class="border-b border-r border-black border-solid px-2.5 text-center">Arrival
                                    </td>
                                    <td class="border-b border-r border-black border-solid px-2.5 text-center">Departure
                                    </td>
                                    <td class="border-b border-r border-black border-solid px-2.5 text-center">Hours
                                    </td>
                                    <td class="border-b border-r border-black border-solid px-2.5 text-center">Minutes
                                    </td>
                                </tr>

                                @foreach (json_decode($dtrData['dtr'])->data as $dateKey => $date)
                                    <tr x-data="{ date: @js($date) }">
                                        <td
                                            class="border-l border-b border-black border-solid px-2.5 py-1  font-bold text-center whitespace-nowrap">
                                            {{ explode('-', $dateKey)[1] }}
                                        </td>
                                        <td class="border-l border-b border-black border-solid px-2.5 py-1  text-center whitespace-nowrap"
                                            :class="{
                                                'font-bold  border-r': date.type === 'Absent' || date.type === 'travel' || typeof(
                                                        date
                                                    ) === 'string' ? true :
                                                    false // This will ensure 'font-bold' is applied if type is 'Absent'
                                            }"
                                            :colspan="typeof(date) === 'string' || date.type == 'travel' ? 6 : 1"
                                            x-text="convertDate(date)"></td>
                                        <td class="border-l border-b border-black border-solid px-2.5 py-1  text-center whitespace-nowrap"
                                            :class="typeof(date) === 'string' || date.type == 'travel' ? 'hidden' : ''"
                                            x-text="formatTime(date.date_departure_am.time)"></td>
                                        <td class="border-l border-b border-black border-solid px-2.5 py-1  text-center whitespace-nowrap"
                                            :class="typeof(date) === 'string' || date.type == 'travel' ? 'hidden' : ''"
                                            x-text="formatTime(date.date_arrival_pm.time)">
                                        </td>
                                        <td class="border-l border-b border-black border-solid px-2.5 py-1  text-center whitespace-nowrap"
                                            :class="typeof(date) === 'string' || date.type == 'travel' ? 'hidden' : ''"
                                            x-text="formatTime(date.date_departure_pm.time)"></td>
                                        <td class="border-l border-b border-black border-solid px-2.5 py-1  text-center whitespace-nowrap"
                                            :class="typeof(date) === 'string' || date.type == 'travel' ? 'hidden' : ''"
                                            x-text="convertUndertime('h',date)">

                                        </td>
                                        <td class="border-x border-b border-black border-solid px-2.5 py-1  text-center whitespace-nowrap"
                                            :class="typeof(date) === 'string' || date.type == 'travel' ? 'hidden' : ''"
                                            x-text="convertUndertime('m',date)">

                                        </td>
                                        {{--                                    <td class="whitespace-nowrap" --}}
                                        {{--                                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ? 'hidden' : ''" --}}
                                        {{--                                        x-text="decrease(date)"></td> --}}
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                        <div class="max-w-[29rem] ">
                            <p class="pb-12 pt-5">I certify on my honor that the above is a true and correct report
                                of the
                                hours
                                of work performed, record of which was made daily at the time of arrival and
                                departure from
                                office.</p>

                            <div class="border-b border-black border-solid"></div>

                            <p class="pt-5 pb-12">VERIFIED as to the prescribed office hours:</p>
                            <div class="border-b border-black border-solid"></div>
                            <p class="text-center">in charge</p>
                        </div>

                    </div>

                </div>
            </div>

        </section>
    </main>

</div>
@script
    <script>
        Alpine.data('skillDisplay', () => ({
            aside: true,
            textWeight: false,
            init() {
                setTimeout(() => {
                    $dispatch('open-modal', {
                        id: 'dtr-id'
                    })
                    console.log('dsad')
                }, 2000)
                // $dispatch('open-modal', {
                //     id: 'edit-user'
                // })

            },
            convertUndertime(type, date) {
                if (date.type != 'Absent' && typeof(date) !== 'string') {
                    const hours = Math.floor(date.undertime / 60); // Calculate hours
                    const minutes = date.undertime % 60; // Calculate remaining minutes

                    if (type == 'm') {
                        // return minutes > 0 ? minutes : '';
                    } else {
                        // return hours > 0 ? hours : '';
                    }

                }

                return '';
            },
            decrease(date) {

                if (date.late > 0 && date.type == 'Full') {
                    // this.total += parseInt(date.late)

                    return 'L = ' + date.late;
                }

            },
            totalPerEmployee(employee) {
                var x = 0;

                Object.entries(employee).forEach(([key, value]) => {
                    if (typeof(value) !== 'string') {

                        x += parseInt(value.undertime)

                        x += parseInt(value.late)
                    }

                });
                const hours = Math.floor(x / 60);
                const minutes = x % 60;
                return `${hours} hours and ${minutes} minutes`;
            },
            totalPerEmployeeMin(employee) {
                var x = 0;

                Object.entries(employee).forEach(([key, value]) => {
                    if (typeof(value) !== 'string') {

                        x += parseInt(value.undertime)

                        x += parseInt(value.late)
                    }

                });

                return `${x} minutes`;
            },
            convertDate(date) {
                if (typeof(date) === 'string') {
                    return date;
                }
                else if (date.type == 'travel') {
                    return date.date_arrival_am.time;
                }
                // else if (date.type == 'Absent') {
                //     // return date.type;
                // }
                else {
                    return this.formatTime(date.date_arrival_am.time);
                }

            },
             formatTime(time) {
                if (!time) return '';
                // Convert 24h to 12h format
                const [hours, minutes] = time.split(':');
                const h = parseInt(hours);
                const ampm = h >= 12 ? 'PM' : 'AM';
                const formattedHours = h % 12 || 12;
                return `${formattedHours}:${minutes} ${ampm}`;

        },
            updateDtr(value, id) {
                $wire.updateDtr(value, id);
            },
            async generateMe() {

                const {
                    jsPDF
                } = window.jspdf;
                const element = document.getElementById('table');

                // Capture the content of the div using html2canvas
                const scale = 5; // Adjust scale for resolution
                const canvas = await html2canvas(element, {
                    scale: scale,
                    useCORS: true
                });

                // Convert the canvas to a data URL with reduced quality
                const imgData = canvas.toDataURL('image/jpeg', 0.8); // Adjust quality (0.8 = 80%)

                // Create a new jsPDF instance with A4 dimensions
                const pdf = new jsPDF('p', 'pt', 'a4'); // 'a4' is a predefined size in jsPDF

                // Define margins
                const margin = 20; // Reduced margin (20 points)
                const pageWidth = pdf.internal.pageSize.getWidth() - 2 * margin; // Printable width
                const pageHeight = pdf.internal.pageSize.getHeight() - 2 * margin; // Printable height

                // Calculate the aspect ratio of the captured image
                const imgAspectRatio = canvas.width / canvas.height;

                // Calculate the dimensions to fit the image within the printable area
                let imgWidth, imgHeight;
                if (imgAspectRatio > 1) {
                    // Landscape image
                    imgWidth = pageWidth;
                    imgHeight = pageWidth / imgAspectRatio;
                    if (imgHeight > pageHeight) {
                        imgHeight = pageHeight;
                        imgWidth = pageHeight * imgAspectRatio;
                    }
                } else {
                    // Portrait image
                    imgHeight = pageHeight;
                    imgWidth = pageHeight * imgAspectRatio;
                    if (imgWidth > pageWidth) {
                        imgWidth = pageWidth;
                        imgHeight = pageWidth / imgAspectRatio;
                    }
                }

                // Center the image on the page
                const x = (pdf.internal.pageSize.getWidth() - imgWidth) / 2;
                const y = (pdf.internal.pageSize.getHeight() - imgHeight) / 2;

                // Add the captured image to the PDF
                pdf.addImage(imgData, 'JPEG', x, 10, imgWidth, imgHeight);

                // Save the PDF
                pdf.save('DTR.pdf');
            },


        }));
    </script>
@endscript
