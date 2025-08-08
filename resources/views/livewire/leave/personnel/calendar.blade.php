<x-assets.admin_layout target="store">
    <x-slot name="modal">
        <div x-cloak class="z-50">
            <x-filament-actions::modals class="z-50" />
        </div>
    </x-slot>
    <div>
        <!-- Breadcrumb -->
        <x-bread-crumb class="py-10" :list="[
            [
                'link' => null,
                'name' => 'Leave',
            ],
            [
                'link' => route('leave.employees'),
                'name' => 'Employees',
            ],
        ]" />

        <div class="p-8 bg-white rounded-lg">
            {{ $this->addEventAction }}

            <div x-ref="calendar" class="bg-white " wire:ignore></div>
        </div>





    </div>


</x-assets.admin_layout>

@script
    <script>
        Alpine.data('skillDisplay', () => ({
            aside: true,
            apexChart: null,
            calendarVar: null,
            eventsx: $wire.$entangle('events'),
            loadCalendar() {
                this.calendarVar = new Calendar(this.$refs.calendar, {
                    plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
                    headerToolbar: {
                        left: 'today,prev,next',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    dayMaxEventRows: 4,
                    selectable: true,
                    displayEventTime: true,
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        meridiem: true
                    },
                    events: this.eventsx,
                    eventContent: function(eventInfo) {


                        const button = `<x-filament::icon-button color="success" size="xs"  icon="heroicon-m-pencil-square" wire:click="mountAction('editEvent', { id: ${eventInfo.event.id} })" label="Edit"/>`
                        const buttonDelete = `<x-filament::icon-button color="danger" size="xs"  icon="heroicon-m-trash" wire:click="mountAction('deleteEvent', { id: ${eventInfo.event.id} })" label="Delete"/>`
                        return {
                            html: `<i>${eventInfo.event.title}</i><div style='display: flex'>${button}${buttonDelete}</div>`, // Render the event title as HTML
                        };
                    },
                    height: '70svh',
                    eventDidMount: function(info) {

                        return tippy(info.el, {
                            content: `<strong>${info.event.title}</strong>`,
                            allowHTML: true,
                            trigger: 'mouseenter',
                            animation: 'fade',
                            theme: 'material',
                            arrow: true,
                            inertia: true,

                        });
                    }


                })

                // this.calendarVar.on('eventClick', function(info) {
                //     $wire.mountAction('test', { id: 12345 })


                // });
            },
            init() {

                this.loadCalendar()
                setTimeout(() => {
                    this.calendarVar.render()
                }, 500);
            }
        }));
    </script>
@endscript
