<?php

namespace App\Livewire\Leave;


use Carbon\Carbon;

use App\Models\user;
use Livewire\Component;

use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Leave\LeaveBulkDtr;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;

use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;

use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Contracts\HasTable;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use Filament\Actions\Contracts\HasActions;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use Coolsam\FilamentFlatpickr\Enums\FlatpickrTheme;
use Filament\Actions\Concerns\InteractsWithActions;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;


class BulkDtr extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;

    public $file, $selectupdateDtr, $dtrArrView;

    public array $dtrArr = [];

    public string $month = '';
    public $globalMonth;

    public function updating($property, $value): void
    {

        if ($property === 'file') {
            $this->file = !!$value ? $value->getFilename() : '';

            $this->loadDtr();
        }
    }

    public function loadDtr(): void
    {
        $arr = [];
        $arrival_am = [];
        $departure_am = [];
        $arrival_pm = [];
        $departure_pm = [];
        $i = [];
        $iterationCount = 1;
        $x = 1;
        $nameColumn = 13;
        if (!$this->file) {
            $this->dtrArr = [];
            return;
        }
        $spreadsheet = new Spreadsheet();
        $templatePath = storage_path('/app/livewire-tmp/' . $this->file);
        $reader = new Xlsx();


        $spreadsheet = $reader->load($templatePath);
        $sheet = $spreadsheet->getSheet(0);



        $this->month = Carbon::parse($sheet->getCell('D15')->getValue())->format('F Y');

        // $days = $this->getAllDaysInMonth($month->format('Y'), $month->format('m'));


        foreach ($sheet->getRowIterator() as $key => $row) {

            if(  $sheet->getCell("A$key")->getValue() == 'In Charge')
            {
                dd( $sheet->getCell("A$key"),$key);
            }
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);

            if (gettype($sheet->getCell("A$key")->getValue()) == 'integer') {
                $i[] = $key;
                $iterationCount++;

                $columnValue = $sheet->getCell("A$key")->getValue();


                $date = Carbon::parse($sheet->getCell('D15')->getValue())->addDays((int)$columnValue - 1);
                $this->globalMonth = Carbon::parse($sheet->getCell('D15')->getValue());

                // $value["$x-$columnValue"] = $date->format('F d, Y');
                $arrival_am["$x-$columnValue"] = $this->getColumnValue("B$key", $sheet, $date, false);
                $departure_am["$x-$columnValue"] = $this->getColumnValue("C$key", $sheet, $date, false);
                $arrival_pm["$x-$columnValue"] = $this->getColumnValue("D$key", $sheet, $date, false);
                $departure_pm["$x-$columnValue"] = $this->getColumnValue("E$key", $sheet, $date, false);

                // $arr["$x-$columnValue"]['date_arrival_am'] =  $arrival_am["$x-$columnValue"];
                // $arr["$x-$columnValue"]['date_departure_am'] =  $departure_am["$x-$columnValue"];
                // $arr["$x-$columnValue"]['date_arrival_pm'] =  $arrival_pm["$x-$columnValue"];
                // $arr["$x-$columnValue"]['date_departure_pm'] =  $departure_pm["$x-$columnValue"];
                // $arr[$sheet->getCell("A$nameColumn")->getValue()] = [];
                $latestUser = LeaveBulkDtr::query()->max('id');
                $increment = (int)$latestUser + 1;
                $arr["$increment-" . str_replace(' ', '_', $this->month) . "--" . $sheet->getCell("A$nameColumn")->getFormattedValue()]['id_number'] = "";
                $arr["$increment-" . str_replace(' ', '_', $this->month) . "--" . $sheet->getCell("A$nameColumn")->getFormattedValue()]['status'] = "PENDING";
                $arr["$increment-" . str_replace(' ', '_', $this->month) . "--" . $sheet->getCell("A$nameColumn")->getFormattedValue()]['data']["$x-$columnValue"] = [
                    'date_arrival_am' => $arrival_am["$x-$columnValue"],
                    'date_departure_am' => $departure_am["$x-$columnValue"],
                    'date_arrival_pm' => $arrival_pm["$x-$columnValue"],
                    'date_departure_pm' => $departure_pm["$x-$columnValue"],
                ];
                if ($iterationCount % 32 === 0) {
                    // Add 20 to the iteration count

                    $iterationCount = 1;
                    $nameColumn += 52;
                    $x++;
                }
            }
        }
        $late = '';
        $undertime = '';
        $type = 'Absent';
        $x = 1;
        $iterationCount = 1;
        $nameColumn = 13;
        //        latest
        foreach ($arr as $key => $days) {

            foreach ($days['data'] as $dayKey => $day) {

                $date = Carbon::parse($this->month)->addDays((int)explode('-', $dayKey)[1] - 1);

                $arrival_start = '';
                $arrival_end = '';
                $departure_start = '';
                $departure_end = '';
                if (!!$day['date_arrival_am']) {
                    $arrival_start = str_contains($day['date_arrival_am'], 'TRAVEL') ? $day['date_arrival_am'] : Carbon::parse($day['date_arrival_am']);
                }

                if (!!$day['date_departure_am']) {
                    $departure_start = str_contains($day['date_departure_am'], 'TRAVEL') ? $day['date_departure_am'] : Carbon::parse($day['date_departure_am']);
                }

                if (!!$day['date_arrival_pm']) {
                    $arrival_end = str_contains($day['date_arrival_pm'], 'TRAVEL') ? $day['date_arrival_pm'] : Carbon::parse($day['date_arrival_pm']);
                }
                if (!!$day['date_departure_pm']) {
                    $departure_end = str_contains($day['date_departure_pm'], 'TRAVEL') ? $day['date_departure_pm'] : Carbon::parse($day['date_departure_pm']);
                }

                // check event
                $event = \App\Models\Leave\LeaveCalendar::query()->whereDate('start', $date)->first();

                if (str_contains($day['date_arrival_am'], 'TRAVEL')) {
                    $type = 'travel';
                } elseif (!!$arrival_start && !!$arrival_end && !!$departure_start && !!$departure_end) {

                    $max_time = $this->minDate($event);
                    $late = $this->estimateLate($arrival_start, $max_time);
                    $difference = $arrival_start->diff($departure_end);
                    $undertime = $this->estimateUndertime($difference);
                    $type = 'Full';
                } elseif ($arrival_start == '' && $arrival_end == '' && $departure_start == '' && $departure_end == '') {

                    $type = 'Absent';
                    $difference = '';
                    $late = 0;
                    $undertime = 0;
                } elseif ($arrival_start == '' && $arrival_end != '' && $departure_start != '' && $departure_end == '') {

                    $type = 'Absent';
                    $difference = '';
                    $late = 0;
                    $undertime = 0;
                } elseif (!!$arrival_start && $arrival_end == '' && !!$departure_start && $departure_end == '') {

                    $type = 'UT';
                    $max_time = $this->minDate($event);
                    $late = $this->estimateLate($arrival_start, $max_time);

                    $difference = $arrival_start->diff($departure_start);
                    $time = sprintf('%02d:%02d', $difference->h - 1, $difference->i);
                    $carbonTime = Carbon::createFromFormat('H:i', $time);
                    // Create a Carbon instance for 8:00:00
                    $eightHours = Carbon::createFromFormat('H:i', '08:00');
                    // Check if the given time is greater than 8 hours
                    if ($carbonTime > $eightHours) {
                        $undertime = 0;
                        $type = 'Full';
                    } else {
                        $differenceTime = $eightHours->diff($carbonTime);
                        $type = 'L/UT';
                        $undertime = $differenceTime->h * 60 + $differenceTime->i;
                    }
                } elseif ($arrival_start == '' && !!$arrival_end && $departure_start == '' && !!$departure_end) {
                    $type = 'UT';
                    $difference = $arrival_end->diff($departure_end);
                    $undertime = $this->estimateUndertime($difference);
                    $late = 0;
                    $undertime = 240;
                } elseif (!!$arrival_start && !!$arrival_end && $departure_start == '' && !!$departure_end) {
                    $max_time = $this->minDate($event);
                    $late = $this->estimateLate($arrival_start, $max_time);
                    $difference = $arrival_start->diff($departure_end);
                    $undertime = $this->estimateUndertime($difference);
                    $type = 'Full';
                } elseif (!!$arrival_start && $arrival_end == '' && !!$departure_start && !!$departure_end) {

                    $max_time = $this->minDate($event);
                    $late = $this->estimateLate($arrival_start, $max_time);

                    $difference = $arrival_start->diff($departure_end);
                    $undertime = $this->estimateUndertime($difference);
                    $type = 'Full';
                } elseif (!!$arrival_start && !!$arrival_end && !!$departure_start && $departure_end == '') {
                    $max_time = $this->minDate($event);
                    $late = $this->estimateLate($arrival_start, $max_time);

                    $difference = $arrival_start->diff($departure_start);
                    $undertime = $this->estimateUndertime($difference);

                    $type = 'UT';
                }

                if ($date->isWeekend()) {

                    if ($date->dayOfWeek == 6) {
                        $arr[$key]['data'][$dayKey] = 'Saturday';
                    } elseif ($date->dayOfWeek == 0) {
                        $arr[$key]['data'][$dayKey] = 'Sunday';
                    }
                } elseif ($event && ($event->type == '2' || $event->type == '3' || $event->type == '4')) {

                    $arr[$key]['data'][$dayKey] = $event->title;
                } else {
                    if ($type != 'Absent') {
                        if ($type == 'travel') {
                            $arr[$key]['data'][$dayKey]['type'] = $type;
                            $arr[$key]['data'][$dayKey]['time'] = "8:00";
                            $arr[$key]['data'][$dayKey]['late'] = $late;
                            $arr[$key]['data'][$dayKey]['undertime'] = $undertime;
                            $arr[$key]['data'][$dayKey]['fc'] = $event && $event->type == '1' ? true : false;
                        } else {
                            if ($type == 'UT') {
                                $hour = $difference->h > 0 ? $difference->h : 0;
                            } else {
                                $hour = $difference->h > 0 ? $difference->h - 1 : 0;
                            }


                            $arr[$key]['data'][$dayKey]['type'] = $type;
                            $arr[$key]['data'][$dayKey]['time'] = "$hour:$difference->i";
                            $arr[$key]['data'][$dayKey]['late'] = $late;
                            $arr[$key]['data'][$dayKey]['undertime'] = $undertime;
                            $arr[$key]['data'][$dayKey]['fc'] = $event && $event->type == '1' ? true : false;
                        }
                    } else {
                        $arr[$key]['data'][$dayKey]['type'] = $type;
                        $arr[$key]['data'][$dayKey]['time'] = "0:0";
                        $arr[$key]['data'][$dayKey]['late'] = $late;
                        $arr[$key]['data'][$dayKey]['undertime'] = $undertime;
                        $arr[$key]['data'][$dayKey]['fc'] = $event && $event->type == '1' ? true : false;
                    }
                }
            }
        }


        $this->dtrArr = $arr;
    }

    public function getColumnValue($column, $sheet, $currentDate, $first = false): string
    {

        $arr = '';
        if ($first) {
            if ($currentDate->isWeekend()) {
                if ($currentDate->dayOfWeek == 6) {
                    $arr = 'Saturday';
                } elseif ($currentDate->dayOfWeek == 0) {
                    $arr = 'Sunday';
                }
            } else {
                if (!!$sheet->getCell($column)->getValue()) {
                    try {
                        $type = gettype($sheet->getCell($column)->getValue());
                        if ($type == 'double') {
                            $hours = $sheet->getCell($column)->getValue() * 24;
                            $time = Carbon::createFromTime((int)$hours, round(($hours - (int)$hours) * 60));
                            $arr = $time->format('h:i A');
                        } else {
                            $date = Carbon::createFromFormat('h:i A', $sheet->getCell($column)->getValue());
                            $arr = $date->format('h:i A');
                        }
                    } catch (\Carbon\Exceptions\InvalidArgumentException $e) {

                        $type = gettype($sheet->getCell($column)->getValue());
                        if ($type == 'double') {
                            $hours = $sheet->getCell($column)->getValue() * 24;
                            $minutes = ($hours - (int)$hours) * 60;

                            $time = Carbon::createFromTime((int)$hours, round($minutes));
                            $arr = $time->format('h:i A');
                        }
                    }
                }
            }
        } else {
            if (!!$sheet->getCell($column)->getValue()) {

                try {
                    $type = gettype($sheet->getCell($column)->getValue());

                    if ($type == 'double') {

                        $hours = $sheet->getCell($column)->getValue() * 24;
                        $minutes = ($hours - (int)$hours) * 60;
                        $time = Carbon::createFromTime((int)$hours, round($minutes));
                        $arr = $time->format('h:i A');
                    } else {
                        //                        $date = Carbon::createFromFormat('h:i A', $sheet->getCell($column)->getValue());
                        //                        $arr = $date->format('h:i A');
                        $date = Carbon::parse($sheet->getCell($column)->getValue());
                        $arr = $date->format('h:i A');
                    }
                } catch (\Carbon\Exceptions\InvalidArgumentException $e) {

                    $type = gettype($sheet->getCell($column)->getValue());
                    if ($type == 'double') {
                        dd($type);
                        $hours = $sheet->getCell($column)->getValue() * 24;
                        $minutes = ($hours - (int)$hours) * 60;
                        $time = Carbon::createFromTime((int)$hours, round($minutes));
                        $arr = $time->format('h:i A');
                    } else if ($type == 'string') {

                        if (strpos($sheet->getCell($column)->getValue(), 'TRAVEL') !== false) {
                            $arr = $sheet->getCell($column)->getValue();
                        } else {
                            $arr = '';
                        }
                    }
                }
            } else {
                $arr = '';
            }
        }
        return $arr;
    }

    public function minDate($event): Carbon
    {
        return $event && $event->type == '1' ? Carbon::parse('07:45 AM') : Carbon::parse('09:00 AM');
    }

    public function estimateLate($start, $max_time)
    {
        $diff = $start->diff($max_time);
        $differenceInMinutes = $diff->h * 60 + $diff->i;

        if ($diff->invert) {
            $late = $differenceInMinutes;
        } else {
            $late = 0;
        }
        return $late;
    }

    public function estimateUndertime($difference): float|int
    {

        $undertime = 0;
        $time = sprintf('%02d:%02d', $difference->h - 1, $difference->i);
        $carbonTime = Carbon::createFromFormat('H:i', $time);

        // Create a Carbon instance for 8:00:00
        $eightHours = Carbon::createFromFormat('H:i', '08:00');

        // Check if the given time is greater than 8 hours
        if ($carbonTime > $eightHours) {
            $undertime = 0;
        } else {
            $differenceTime = $eightHours->diff($carbonTime);

            $undertime = $differenceTime->h * 60 + $differenceTime->i;
        }
        return $undertime;
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->requiresConfirmation()
            ->action(fn() => dd('dsad'));
    }

    public function updated($property, $value)
    {
        if ($property === 'selectupdateDtr') {
            //            dd($value);
        }
    }

    public function updateDtr($value, $id)
    {
        dd($value);
    }

    public function table(Table $table): Table
    {

        return $table
            ->query(\App\Models\Leave\LeaveBulkDtr::query()->orderByDesc('created_at'))
            ->headerActions([

                Action::make('dtr')
                    ->label('Create Bulk Dtr')
                    ->icon('heroicon-o-calendar-days')
                    ->label('DTR')
                    ->form([
                        TextInput::make('batch')
                            ->required(),

                        ViewField::make('Attachment')
                            ->view('livewire.leave.asset.dtr'),
                    ])
                    ->cancelParentActions()
                    ->extraModalFooterActions([
                        Action::make('Cancel')
                            ->label('Cancel')
                            ->color(Color::Gray)
                            ->action(function ($action) {
                                $this->file = '';
                                $this->loadDtr();
                                $action->cancelParentActions();
                            })
                    ])
                    ->slideOver()
                    ->modalCancelAction(false)
                    ->action(function ($data, $record) {
                        \App\Models\Leave\LeaveBulkDtr::query()->create([
                            'id_number' => Auth::user()->id_number,
                            'dtr' => json_encode($this->dtrArr),
                            'date' => $this->month,
                            'batch' => $data['batch'],

                        ]);
                        Notification::make()
                            ->title('Success!')
                            ->body('The form has been submitted successfully.')
                            ->success()
                            ->send();
                    })
            ])
            ->columns([
                TextColumn::make('date'),
                TextColumn::make('batch'),

            ])
            //            ->deferFilters()
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Flatpickr::make('date')
                            ->theme(FlatpickrTheme::DARK)
                            ->monthSelect()
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['date'],
                                fn($query, $date) => $query->whereDate('date', '=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data) {
                        if (!$data['date']) {
                            return null;
                        }

                        return 'Date:  ' . Carbon::parse($data['date'])->format('F Y');
                    })
            ])
            ->actions([

                ViewAction::make('information')
                    ->icon('heroicon-o-eye')
                    ->mutateRecordDataUsing(function ($data) {

                        $this->dtrArrView = json_decode($data['dtr']);
                        return $data;
                    })
                    ->form([
                        ViewField::make('viewDtr')
                            ->view('livewire.leave.asset.dtr_view')
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

                            ]),
                    ])
                    ->modalWidth(MaxWidth::Full)
                    ->slideOver()
            ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('author_id')
                    ->label('Author')
                    ->options(User::all()->pluck('name', 'id_number'))
                    ->searchable()
                    ->native(false)
                    ->extraAlpineAttributes(['x-on:change' => 'updateDtr($event.target.value,model)'])
            ]);
    }

    function getAllDaysInMonth($year, $month)
    {
        // Create a Carbon instance for the first day of the month
        $startDate = Carbon::createFromDate($year, $month, 1);

        // Get the number of days in the month
        $daysInMonth = $startDate->daysInMonth;

        // Create an array to hold all the days
        $days = [];

        // Loop through each day of the month
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $days[] = $startDate->copy()->day($day)->toDateString();
        }

        return $days;
    }

    public function render(): View
    {


        return view('livewire.leave.bulk_dtr');
    }
}
