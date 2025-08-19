<?php

namespace App\Livewire\Leave\Personnel;

use Carbon\Carbon;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use Carbon\CarbonPeriod;
use Filament\Actions\Action;
use Spatie\GoogleCalendar\Event;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;

class Calendar extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $events = [];
    public $name = 'dsada';
    public function disabledWeekEnds()
    {

        $start = Carbon::now();
        $end = Carbon::now()->addYear(10);
        $period = CarbonPeriod::create($start, $end);

        $weekends = [];
        foreach ($period as $date) {
            if ($date->isWeekend()) {
                $weekends[] = $date->format('Y-m-d');
            }
        }

        return $weekends;
    }

    public function addEventAction(): Action
    {
        return Action::make('addEvent')
            ->form([
                Select::make('type')
                    ->reactive()
                    ->options([
                        '1' => 'Flag Ceremony',
                        '2' => 'Regular Holidays',
                        '3' => 'Special Non-Working Holidays',
                        '4' => 'Work Suspension',
                        '5' => 'Halday/Customize',
                    ])->required()
                    ->afterStateUpdated(function (Set $set, $state) {
                        // Update the title based on the selected type
                        if ($state == '1') {
                            $set('title', 'Flag Ceremony');
                        } else {
                            $set('title', ''); // Clear the title if not 'Flag Ceremony'
                        }
                    }),
                TextInput::make('title')
                    ->reactive()
                    // ->visible(fn(Get $get) => !!$get('type') && $get('type') != '1' ? true : false)
                    ->required(),


                DatePicker::make('start')
                    ->native(false)
                    ->required(),
                TimePicker::make('max_departure')
                    ->required()
                    ->hidden(fn(Get $get) => $get('type') != '5' || $get('type') == '')
                // ->visible(fn(Get $get) => !!$get('type') ? true : false),

                // DatePicker::make('end')
                // ->native(false),
                // TimePicker::make('startTime')->seconds(false),
                // TimePicker::make('endTime')->seconds(false),
                // ColorPicker::make('backgroundColor')
            ])
            ->action(function ($data) {

                if ($data['type'] == '1') {
                } elseif ($data['type'] == '2') {
                    $data['backgroundColor'] = '#f54242';
                } elseif ($data['type'] == '3') {
                    $data['backgroundColor'] = '#535955';
                } elseif ($data['type'] == '4') {
                    $data['backgroundColor'] = '#fa6000';
                }elseif ($data['type'] == '5') {
                    $data['backgroundColor'] = '#fa6000';
                }
                $data['start'] = Carbon::parse($data['start'])->format('Y-m-d');
                // $data['end'] = !!$data['end'] ?  Carbon::parse($data['end'])->addDay()->format('Y-m-d') : null;
                $data['id_number'] = Auth::user()->id_number;
                \App\Models\Leave\LeaveCalendar::create($data);
                Notification::make()
                    ->title('Created successfully')
                    ->success()
                    ->send();
                return redirect()->route('leave.personnel.calendar');
            });
    }

    public function editEventAction(): Action
    {
        return Action::make('editEvent')

            ->iconButton()
            ->icon('heroicon-o-pencil-square')
            ->form(function ($arguments) {
                $data = \App\Models\Leave\LeaveCalendar::where('id', $arguments['id'])->first();
                return [
                    TextInput::make('title')->default($data?->title),
                    DatePicker::make('start')
                        ->native(false)
                        ->required()->default($data?->start),
                    // DatePicker::make('end')->default($data?->end)
                    //     ->native(false),
                    Select::make('type')
                        ->options([
                            '1' => 'Flag Ceremony',
                            '2' => 'Regular Holidays',
                            '3' => 'Special Non-Working Holidays',
                            '4' => 'Work Suspended',
                        ])->required()->default($data?->type),
                    // TimePicker::make('startTime')->seconds(false),
                    // TimePicker::make('endTime')->seconds(false),

                    // ColorPicker::make('backgroundColor')->default($data?->backgroundColor)

 Select::make('type')
                    ->reactive()
                    ->options([
                        '1' => 'Flag Ceremony',
                        '2' => 'Regular Holidays',
                        '3' => 'Special Non-Working Holidays',
                        '4' => 'Work Suspension',
                        '5' => 'Halday/Customize',
                    ])->required()->deafult($data?->type)
                    ->afterStateUpdated(function (Set $set, $state) {
                        // Update the title based on the selected type
                        if ($state == '1') {
                            $set('title', 'Flag Ceremony');
                        } else {
                            $set('title', ''); // Clear the title if not 'Flag Ceremony'
                        }
                    }),
                TextInput::make('title')
                    ->reactive()
                    // ->visible(fn(Get $get) => !!$get('type') && $get('type') != '1' ? true : false)
                    ->required()->default($data?->title),


                DatePicker::make('start')
                    ->native(false)
                    ->required(),
                TimePicker::make('max_departure')
                    ->required()
                    ->hidden(fn(Get $get) => $get('type') != '5' || $get('type') == '')
                ];
            })
            ->action(function ($data, $arguments) {
                if ($data['type'] == '1') {
                } elseif ($data['type'] == '2') {
                    $data['backgroundColor'] = '#f54242';
                } elseif ($data['type'] == '3') {
                    $data['backgroundColor'] = '#535955';
                } elseif ($data['type'] == '4') {
                    $data['backgroundColor'] = '#fa6000';
                }
                $data['start'] = Carbon::parse($data['start'])->format('Y-m-d');
                // $data['end'] = !!$data['end'] ?  Carbon::parse($data['end'])->addDay()->format('Y-m-d') : null;
                $data['id_number'] = Auth::user()->id_number;
                \App\Models\Leave\LeaveCalendar::where('id', $arguments['id'])->update($data);
                Notification::make()
                    ->title('Updated successfully')
                    ->success()
                    ->send();
                return redirect()->route('leave.personnel.calendar');
            });
    }
    public function deleteEventAction(): Action
    {
        return Action::make('deleteEvent')
            ->color(Color::Red)
            ->iconButton()
            ->icon('heroicon-o-trash')
            ->requiresConfirmation()
            ->action(function ($arguments) {

                \App\Models\Leave\LeaveCalendar::where('id', $arguments['id'])->delete();
                Notification::make()
                    ->title('Deleted successfully')
                    ->success()
                    ->send();
                return redirect()->route('leave.personnel.calendar');
            });
    }
    public function render()
    {
        $this->events = \App\Models\Leave\LeaveCalendar::select('id', 'title', 'start', 'end', 'backgroundColor')->get()->toArray();
        // dd($this->events);
        //         $startDate = Carbon::now()->startOfYear()->addDay(); // Start of the year
        // $endDate = Carbon::now()->endOfYear(); // End of the year
        // $events = Event::get($startDate, $endDate);
        // dd($events[0]);
        // dd(Carbon::now()->format('Y-m-d\TH:i:s'));
        return view('livewire.leave.personnel.calendar');
    }
}
