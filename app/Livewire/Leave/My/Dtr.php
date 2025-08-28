<?php

namespace App\Livewire\Leave\My;

use App\Traits\Leave\PersonnelLeaveTrait;
use Livewire\Component;
use Filament\Forms\Form;

use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Dtr extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    use PersonnelLeaveTrait;
    public $name = [];
    protected $rules = [
        'name.*' => 'string|null',
    ];
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\Leave\LeaveBulkDtr::query()->where('id_number', Auth::user()->id_number)->orderBy('id', 'desc'))
            ->columns([
                TextColumn::make('id')->label('Ref no.'),
                TextColumn::make('batch'),
                TextColumn::make('user_name'),
                TextColumn::make('date')->date('F Y'),
            ])
            ->actions([

                ViewAction::make('information')
                ->label('Print')
                    ->icon('heroicon-m-printer')
                    ->mutateRecordDataUsing(function ($data) {
                        // $this->employee = [
                        //     'author_id' => $data['id_number']
                        // ];
                        // $this->dtrArrView = $data;
                        return $data;
                    })
                    ->form(function ($record) {

                        return [
                            ViewField::make('viewDtr')
                                ->view('livewire.leave.my.dtr_print_employee')
                                ->registerActions([
                                    \Filament\Forms\Components\Actions\Action::make('dtr')
                                        ->label('DTR')
                                        ->iconButton()
                                        ->icon('heroicon-m-printer')
                                        ->form(function ($arguments) {

                                            $keys = array_keys($arguments);
                                            $route = route('dtr_qrcode', ['dtr_id' => $keys[0]]);

                                            $image = QrCode::generate($route);

                                            $base64Image = 'data:image/svg+xml;base64,' . base64_encode($image);

                                            return [
                                                ViewField::make('dtr_print')
                                                    ->view('livewire.leave.asset.dtr_print')
                                                    ->viewData([
                                                        'data' => $arguments,
                                                        'qrcode' => $base64Image
                                                    ])
                                            ];
                                        })
                                        ->extraAttributes(['id' => 'dtr-id'])
                                        ->slideOver()
                                        ->modalSubmitAction(false),

                                ])->viewData([
                                    'dtrData' => $record
                                ]),
                        ];
                    })
                    ->modalWidth(MaxWidth::FitContent)
                    ->slideOver(),
                Action::make('slideOverDtr')
                    ->label('DTR')
                    ->icon('heroicon-m-calendar-days')
                    ->color(Color::Rose)
                    ->size('sm')
                    ->form(function ($record) {

                        foreach (json_decode($record->dtr, true)['data'] as $key => $value) {
                            foreach (['date_arrival_am', 'date_departure_am', 'date_arrival_pm', 'date_departure_pm'] as $keyLabel => $valueKey) {

                                $index = explode('-', $key)[1] . '-' . $keyLabel + 1;

                                // SAFEST APPROACH - Using Laravel's data_get()
                                $timeValue = data_get($value, $valueKey . '.time');

                                // OR with null coalescing
                                $timeValue = $value['date_arrival_pm']['time'] ?? null;

                                // OR with full validation
                                if (
                                    is_array($value[$valueKey] ?? null) &&
                                    array_key_exists('time', $value[$valueKey])
                                ) {
                                    $timeValue = $value[$valueKey]['time'];
                                } else {
                                    $timeValue = null; // or your default value
                                }

                                $this->name[$index] = $timeValue;
                            }
                            // $this->name[explode('-', $key)[1].'-3'] = $value['date_arrival_pm']['time'];
                            // $this->name[explode('-', $key)[1].'-4'] = $value['date_departure_pm']['time'];
                        }

                        return [
                            ViewField::make('rating')
                                ->view('livewire.leave.my.dtr_edit_employee')
                                ->viewData([
                                    'dtrData' => $record,
                                ])
                        ];
                    })
                    ->modalWidth(MaxWidth::ScreenExtraLarge)
                    ->slideOver()
                    ->action(function ($record) {

                        $data = json_decode($record->dtr, true)['data'];
                        $newData = json_decode($record->dtr, true);


                        //                       "date_arrival_am" => ""
                        // "date_arrival_pm" => ""
                        // "date_departure_am" => ""
                        // "date_departure_pm" => ""

                        foreach ($this->name as $key => $value) {

                            try {
                                // $time = Carbon::parse($value)->format('h:i A');
                                if (str_contains($value, 'TRAVEL')) {
                                    $data[explode('-', $key)[0] . '-' . explode('-', $key)[0]]['date_arrival_am']['time'] = $value;
                                }
                                  $time = Carbon::parse($value)->format('H:i');

                                    if (!!$value) {
                                        if (explode('-', $key)[1] == 1) {
                                            $data[explode('-', $key)[0] . '-' . explode('-', $key)[0]]['date_arrival_am']['time'] = $time;
                                        }
                                        if (explode('-', $key)[1] == 3) {
                                            $data[explode('-', $key)[0] . '-' . explode('-', $key)[0]]['date_arrival_pm']['time'] = $time;
                                        }
                                        if (explode('-', $key)[1] == 2) {
                                            $data[explode('-', $key)[0] . '-' . explode('-', $key)[0]]['date_departure_am']['time'] = $time;
                                        }
                                        if (explode('-', $key)[1] == 4) {
                                            $data[explode('-', $key)[0] . '-' . explode('-', $key)[0]]['date_departure_pm']['time'] = $time;
                                        }
                                    }
                            } catch (\Exception $e) {
                                Notification::make()
                                    ->title($e->getMessage())
                                    ->success()
                                    ->send();
                            }
                        }
                        $newData['data'] = $data;

                        $record->update([
                            'dtr' => json_encode($newData),
                        ]);
                        $late = '';
                        $undertime = '';
                        $type = 'Absent';
                        foreach ($newData['data'] as $dayKey => $day) {

                            $fc = false;
                            $date = Carbon::parse($record->date)->addDays((int)explode('-', $dayKey)[1] - 1);

                            $arrival_start = '';
                            $arrival_end = '';
                            $departure_start = '';
                            $departure_end = '';
                            $editable = true;
                            if (is_string($day)) {
                                $arr['data'][$dayKey] = $day;
                                continue;
                            }

                            if (!!$day['date_arrival_am']['time']) {
                                $arrival_start = str_contains($day['date_arrival_am']['time'], 'TRAVEL') ? $day['date_arrival_am']['time'] : Carbon::parse($day['date_arrival_am']['time']);
                            }

                            if (!!$day['date_departure_am']['time']) {
                                $departure_start = str_contains($day['date_departure_am']['time'], 'TRAVEL') ? $day['date_departure_am']['time'] : Carbon::parse($day['date_departure_am']['time']);
                            }

                            if (!!$day['date_arrival_pm']['time']) {
                                $arrival_end = str_contains($day['date_arrival_pm']['time'], 'TRAVEL') ? $day['date_arrival_pm']['time'] : Carbon::parse($day['date_arrival_pm']['time']);
                            }
                            if (!!$day['date_departure_pm']['time']) {
                                $departure_end = str_contains($day['date_departure_pm']['time'], 'TRAVEL') ? $day['date_departure_pm']['time'] : Carbon::parse($day['date_departure_pm']['time']);
                            }

                            // check event
                            $event = \App\Models\Leave\LeaveCalendar::query()->whereDate('start', $date)->first();
                            $fc = $event?->type == '1' ? true : false;
                            if (str_contains($day['date_arrival_am']['time'], 'TRAVEL')) {
                                $type = 'travel';
                                $editable = false;
                            }
                            if ($arrival_start  == '' && $departure_start  == '' && $arrival_end  == '' &&  $departure_end == '') {
                                // if ($arrival_start == '' && $arrival_end == '' && $departure_start == '' && $departure_end == '') {

                                $type = 'Absent';
                                $difference = '';
                                $late = 0;
                                $undertime = 0;
                            }

                            if (!!$arrival_start && !!$departure_start && !!$arrival_end &&  !!$departure_end) {

                                [$editable, $type, $undertime, $late, $difference] = $this->loadDtrCondition($arrival_start, $departure_end, $event, $departure_start, $arrival_end, $fc);
                            }
                            if (!!$arrival_start && !!$departure_start && !!$arrival_end &&  $departure_end == '') {

                                [$editable, $type, $undertime, $late, $difference] =  $this->loadDtrCondition($arrival_start, $arrival_end, $event, $departure_start, $arrival_end, $fc);
                            }

                            if (!!$arrival_start && !!$departure_start && $arrival_end == '' &&  $departure_end == '') {

                                [$editable, $type, $undertime, $late, $difference] =  $this->loadDtrCondition($arrival_start, $departure_start, $event, $departure_start, $departure_start, $fc);
                            }

                            if (!!$arrival_start && !!$departure_start && $arrival_end == '' &&  !!$departure_end) {

                                [$editable, $type, $undertime, $late, $difference] =  $this->loadDtrCondition($arrival_start, $departure_end, $event, $departure_start, $departure_start, $fc);
                            }

                            if ($event && ($event->type == '2' || $event->type == '3' || $event->type == '4')) {

                                $arr['data'][$dayKey] = $event->title;
                            } else {
                                if ($type != 'Absent') {
                                    if ($type == 'travel') {
                                        $arr['data'][$dayKey]['type'] = $type;
                                        $arr['data'][$dayKey]['time'] = "8:00";
                                        $arr['data'][$dayKey]['late'] = $late;
                                        $arr['data'][$dayKey]['undertime'] = $undertime;
                                        $arr['data'][$dayKey]['fc'] = $event && $event->type == '1' ? true : false;
                                    } else {
                                        if ($type == 'UT') {
                                            $hour = $difference->h > 0 ? $difference->h : 0;
                                        } else {
                                            $hour = $difference->h > 0 ? $difference->h - 1 : 0;
                                        }


                                        $arr['data'][$dayKey]['type'] = $type;
                                        $arr['data'][$dayKey]['time'] = "$hour:$difference->i";
                                        $arr['data'][$dayKey]['late'] = $late;
                                        $arr['data'][$dayKey]['undertime'] = $undertime;
                                        $arr['data'][$dayKey]['fc'] = $event && $event->type == '1' ? true : false;
                                        $arr['data'][$dayKey]['editable'] =  $editable;
                                    }
                                } else {
                                    $arr['data'][$dayKey]['type'] = $type;
                                    $arr['data'][$dayKey]['time'] = "0:0";
                                    $arr['data'][$dayKey]['late'] = $late;
                                    $arr['data'][$dayKey]['undertime'] = $undertime;
                                    $arr['data'][$dayKey]['fc'] = $event && $event->type == '1' ? true : false;
                                    $arr['data'][$dayKey]['editable'] =  $editable;
                                }
                            }
                            $arr['data'][$dayKey]['date_arrival_am'] = $day['date_arrival_am'];
                            $arr['data'][$dayKey]['date_departure_am'] = $day['date_departure_am'];
                            $arr['data'][$dayKey]['date_arrival_pm'] = $day['date_arrival_pm'];
                            $arr['data'][$dayKey]['date_departure_pm'] = $day['date_departure_pm'];
                        }
                        $newData['data'] = $arr['data'];

                        $record->update([
                            'dtr' => json_encode($newData),
                        ]);


                        Notification::make()
                            ->title('Updated Successfully!')
                            ->success()
                            ->send();
                    })
                    ->modalCancelActionLabel('Close')

            ])
        ;
    }

    public function render()
    {
        return view('livewire.leave.my.dtr');
    }
}
