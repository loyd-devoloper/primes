<?php

namespace App\Livewire\Leave;

use Carbon\Carbon;
use App\Models\User;

use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Employees extends Component  implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    #[Url()]
    public $tab = 'EMPLOYEES';

    public $dtr;
    public $file;
    public $dtrArr = [];
    public $month = '';

    //    filter variable
    public $dateFilter;
    public function updating($property, $value)
    {


        if ($property === 'file') {
            $this->file = $value->getFilename();

            $this->loadDtr();
        }
    }


    public function loadDtr(): void
    {

        $spreadsheet = new Spreadsheet();
        $templatePath = storage_path('/app/livewire-tmp/' . $this->file);
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadsheet = $reader->load($templatePath);
        $sheet = $spreadsheet->getSheet(0);


        $year = 2024;
        $month = 12;
        $days = $this->getAllDaysInMonth($year, $month);

        // $month = Carbon::parse($sheet->getCell('D15')->getValue());

        $arr = [];

        $value = [];
        $typeOf = [];
        $arrival_am = [];
        $departure_am = [];
        $arrival_pm = [];
        $departure_pm = [];
        $i = [];
        $iterationCount = 1;
        $x = 1;
        $nameColumn = 13;
        foreach ($sheet->getRowIterator() as $key => $row) {




            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);

            if (gettype($sheet->getCell("A$key")->getValue()) == 'integer') {
                $i[] = $key;
                $iterationCount++;

                $columnValue = $sheet->getCell("A$key")->getValue();



                $date = Carbon::parse($sheet->getCell('D15')->getValue())->addDays((int)$columnValue);
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
                $arr[$sheet->getCell("A$nameColumn")->getValue()]["$x-$columnValue"] = [
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
        // dd($arr);
        $late = '';
        $undertime = '';
        $type = 'Absent';
        $x = 1;
        $iterationCount = 1;
        $nameColumn = 13;
        foreach ($sheet->getRowIterator() as $key => $row) {


            if (gettype($sheet->getCell("A$key")->getValue()) == 'integer') {
                $i[] = $key;
                $iterationCount++;
                $columnValue = $sheet->getCell("A$key")->getValue();
                $date = Carbon::parse($sheet->getCell('D15')->getValue())->addDays((int)$columnValue - 1);

                $arrival_start = !!$arrival_am["$x-$columnValue"] ? Carbon::parse($arrival_am["$x-$columnValue"]) : '';
                $arrival_end = !!$arrival_pm["$x-$columnValue"] ? Carbon::parse($arrival_pm["$x-$columnValue"]) : '';
                $departure_start = !!$departure_am["$x-$columnValue"] ? Carbon::parse($departure_am["$x-$columnValue"]) : '';
                $departure_end =  !!$departure_pm["$x-$columnValue"] ? Carbon::parse($departure_pm["$x-$columnValue"]) : '';

                $event = \App\Models\Leave\LeaveCalendar::whereDate('start', $date)->first();

                if (!!$arrival_start && !!$arrival_end && !!$departure_start && !!$departure_end) {

                    if ($event && $event->type == '1') {
                        $maxtime = Carbon::parse('07:45 AM');
                    } else {
                        $maxtime = Carbon::parse('09:00 AM');
                    }
                    $difference = $arrival_start->diff($departure_end);


                    $diff = $arrival_start->diff($maxtime);
                    $differenceInMinutes = $diff->h * 60 + $diff->i;
                    $undertime = 0;
                    if ($diff->invert) {
                        $late = $differenceInMinutes;
                    } else {
                        $late = 0;
                    }

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
                    $type = 'Full';
                } elseif ($arrival_start == '' && $arrival_end  == '' && $departure_start == '' && $departure_end  == '') {
                    $type = 'Absent';
                    $difference = '';
                    $late = 0;
                    $undertime = 0;
                } elseif (!!$arrival_start && $arrival_end == '' && !!$departure_start && $departure_end == '') {

                    $type = 'UT';
                    $difference = $arrival_start->diff($departure_start);

                    $late = 0;
                    $undertime = 240;
                } elseif ($arrival_start == '' && !!$arrival_end  && $departure_start == '' && !!$departure_end) {
                    $type = 'UT';
                    $difference = $arrival_end->diff($departure_end);

                    $late = 0;

                    $undertime = 240;
                } elseif (!!$arrival_start && !!$arrival_end  && $departure_start == '' && !!$departure_end) {
                    if ($event && $event->type == '1') {
                        $maxtime = Carbon::parse('07:45 AM');
                    } else {
                        $maxtime = Carbon::parse('09:00 AM');
                    }
                    $difference = $arrival_start->diff($departure_end);


                    $diff = $arrival_start->diff($maxtime);
                    $differenceInMinutes = $diff->h * 60 + $diff->i;
                    $undertime = 0;
                    if ($diff->invert) {
                        $late = $differenceInMinutes;
                    } else {
                        $late = 0;
                    }

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
                    $type = 'Full';
                } elseif (!!$arrival_start && $arrival_end == ''  && !!$departure_start && !!$departure_end) {
                    if ($event && $event->type == '1') {
                        $maxtime = Carbon::parse('07:45 AM');
                    } else {
                        $maxtime = Carbon::parse('09:00 AM');
                    }
                    $difference = $arrival_start->diff($departure_end);


                    $diff = $arrival_start->diff($maxtime);
                    $differenceInMinutes = $diff->h * 60 + $diff->i;
                    $undertime = 0;
                    if ($diff->invert) {
                        $late = $differenceInMinutes;
                    } else {
                        $late = 0;
                    }

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
                    $type = 'Full';
                } elseif (!!$arrival_start && !!$arrival_end && !!$departure_start && $departure_end == '') {
                    if ($event && $event->type == '1') {
                        $maxtime = Carbon::parse('07:45 AM');
                    } else {
                        $maxtime = Carbon::parse('09:00 AM');
                    }
                    $difference = $arrival_start->diff($arrival_end);


                    $diff = $arrival_start->diff($maxtime);
                    $differenceInMinutes = $diff->h * 60 + $diff->i;
                    $undertime = 0;
                    if ($diff->invert) {
                        $late = $differenceInMinutes;
                    } else {
                        $late = 0;
                    }

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
                    $type = 'UT';
                }

                if ($date->isWeekend()) {

                    if ($date->dayOfWeek == 6) {
                        $arr[$sheet->getCell("A$nameColumn")->getValue()]["$x-$columnValue"] = 'Saturday';
                    } elseif ($date->dayOfWeek == 0) {
                        $arr[$sheet->getCell("A$nameColumn")->getValue()]["$x-$columnValue"] = 'Sunday';
                    }
                } elseif ($event && ($event->type == '2' || $event->type == '3' || $event->type == '4')) {


                    $arr[$sheet->getCell("A$nameColumn")->getValue()]["$x-$columnValue"] = $event->title;
                } else {

                    if ($type != 'Absent') {
                        if ($type == 'UT') {
                            $hour = $difference->h > 0 ? $difference->h : 0;
                        } else {
                            $hour = $difference->h > 0 ? $difference->h - 1 : 0;
                        }


                        $arr[$sheet->getCell("A$nameColumn")->getValue()]["$x-$columnValue"]['type'] = $type;
                        $arr[$sheet->getCell("A$nameColumn")->getValue()]["$x-$columnValue"]['time'] = "$hour:$difference->i";
                        $arr[$sheet->getCell("A$nameColumn")->getValue()]["$x-$columnValue"]['late'] = $late;
                        $arr[$sheet->getCell("A$nameColumn")->getValue()]["$x-$columnValue"]['undertime'] = $undertime;
                        $arr[$sheet->getCell("A$nameColumn")->getValue()]["$x-$columnValue"]['fc'] = $event && $event->type == '1' ? true : false;
                    } else {

                        $arr[$sheet->getCell("A$nameColumn")->getValue()]["$x-$columnValue"]['type'] = $type;
                        $arr[$sheet->getCell("A$nameColumn")->getValue()]["$x-$columnValue"]['time'] = "0:0";
                        $arr[$sheet->getCell("A$nameColumn")->getValue()]["$x-$columnValue"]['late'] = $late;
                        $arr[$sheet->getCell("A$nameColumn")->getValue()]["$x-$columnValue"]['undertime'] = $undertime;
                        $arr[$sheet->getCell("A$nameColumn")->getValue()]["$x-$columnValue"]['fc'] = $event && $event->type == '1' ? true : false;
                    }
                }

                if ($iterationCount % 32 === 0) {
                    // Add 20 to the iteration count
                    $iterationCount = 1;
                    $nameColumn += 52;
                    $x++;
                }
            }
        }

        $this->dtrArr = $arr;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query()
                ->select('id', 'name', 'id_number', 'fd_code', 'profile')
                ->with(['leaveEarn', 'user_fd_code', 'leavePointLatest', 'leaveRequests' => function ($query) {
                    $query->where('status', \App\Enums\LeaveStatusEnum::APPROVED->value);
                }])
                ->whereHas('workExperienceCurrent', function ($query) {
                    $query->where('status_appointment', 'Permanent');
                }))

            ->columns([
                // ImageColumn::make('profile')->circular()->width(50)->height(50)->defaultImageUrl(url('/assets/no_image.jpg')),
                TextColumn::make('name')->searchable(),
                TextColumn::make('leavePointLatest')->label('Leave Status')->searchable()->state(fn($record) => $record?->leavePointLatest?->current_month),
                TextColumn::make('user_fd_code.division_name')->label('Unit/Division')->searchable(),
            ])
            ->filters([
                Filter::make('is_featured')
                    ->form([
                        DatePicker::make('created_at')
                            ->label('Leave Request at')
                            ->format('Y-m-d')
                            ->live()

                    ])
                    ->query(function ($query, array $data) {
                        $this->dateFilter = $data['created_at'];
                        return $query
                            ->when(
                                $data['created_at'],
                                fn($query, $date) => $query->whereHas('leaveRequests', function ($q) use ($date) {

                                    $q->whereJsonContains('date', $date)->where('status', \App\Enums\LeaveStatusEnum::APPROVED->value);;
                                })
                            );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['created_at']) {
                            return null;
                        }

                        return 'Leave Request at ' . Carbon::parse($data['created_at'])->toFormattedDateString();
                    })
            ])
            ->bulkActions([
                BulkAction::make('Add Points')
                    ->form([
                        TextInput::make('reason')->required(),

                    ])
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion()
                    ->action(function ($records, $data) {
                        if (!!$this->dateFilter) {
                            $records->each(function ($record) use ($data) {
                                $request = \App\Models\LeaveEmployeeRequest::query()
                                    ->where('id_number', $record->id_number)
                                    ->whereJsonContains('date', $this->dateFilter)
                                    ->where('status', \App\Enums\LeaveStatusEnum::APPROVED->value)
                                    ->first();
                                if ($request->type_of_leave == \App\Enums\TypeOfLeaveEnum::VACATION_LEAVE->value || $request->type_of_leave == \App\Enums\TypeOfLeaveEnum::FORCE_LEAVE->value) {
                                    \App\Models\Leave\LeaveCard::query()
                                        ->create([
                                            'start_date' => Carbon::now(),
                                            'particulars' => $data['reason'],
                                            'vl_earn' => 1,

                                            'remarks' => Carbon::parse($this->dateFilter)->format('M d, Y'),
                                            'vl_balance' => (float)$record->leavePointLatest?->vl + 1,
                                            'sl_balance' => $record->leavePointLatest?->sl,
                                            'id_number' => $record->id_number
                                        ]);
                                    $record->leavePointLatest->update([
                                        'vl' => (float)$record->leavePointLatest?->vl + 1
                                    ]);
                                } else if ($request->type_of_leave == \App\Enums\TypeOfLeaveEnum::SPECIAL_PRIVILEGE_LEAVE->value) {
                                    \App\Models\Leave\LeaveCard::query()
                                        ->create([
                                            'start_date' => Carbon::now(),
                                            'particulars' => $data['reason'],
                                            'remarks' => Carbon::parse($this->dateFilter)->format('M d, Y'),
                                            'vl_balance' => (float)$record->leavePointLatest?->vl,
                                            'sl_balance' => $record->leavePointLatest?->sl,
                                            'id_number' => $record->id_number
                                        ]);
                                    $record->leavePointLatest->update([
                                        'vl' => (float)$record->leavePointLatest?->spl + 1
                                    ]);
                                } else if ($request->type_of_leave == \App\Enums\TypeOfLeaveEnum::SICK_LEAVE->value) {
                                    \App\Models\Leave\LeaveCard::query()
                                        ->create([
                                            'start_date' => Carbon::now(),
                                            'particulars' => $data['reason'],
                                            'sl_earn' => 1,

                                            'remarks' => Carbon::parse($this->dateFilter)->format('M d, Y'),
                                            'vl_balance' => $record->leavePointLatest?->vl,
                                            'sl_balance' => (float)$record->leavePointLatest?->sl  + 1,
                                            'id_number' => $record->id_number
                                        ]);
                                    $record->leavePointLatest->update([
                                        'vl' => (float)$record->leavePointLatest?->sl + 1
                                    ]);
                                }
                            });
                            Notification::make()
                                ->title('Submitted successfully')
                                ->success()
                                ->duration(5000)
                                ->send();
                        }
                    })

            ])
            ->checkIfRecordIsSelectableUsing(
                fn($record): bool => !!$this->dateFilter
            )
            ->actions([
                ActionGroup::make([
                    Action::make('Leave Dashboardx')
                        ->label('LATE UNDERTIME')
                        ->form(function ($record) {
                            return [
                                Fieldset::make('Label')->label('L/UT')
                                    ->schema([
                                        Repeater::make('L/UT')
                                            ->label(false)
                                            ->schema([
                                                TextInput::make('particular')->label('L / UT')->required()->mask('99-99-99') ->hint('Day-Hour-Minute')->live()
                                                    ->helperText(function (Set $set, Get $get) {
                                                        $advanceSetting = \App\Models\Leave\LeaveAdvanceSetting::query()->where('id', 1)->first();
                                                        if (preg_match('/^\d{2}-\d{2}-\d{2}$/', $get('particular'))) {
                                                            [$day, $hour, $min] = explode('-', $get('particular'));

                                                            $total = $advanceSetting['days' . (int)$day] + $advanceSetting['hours' . (int)$hour] + $advanceSetting['min' . (int)$min];


                                                            return $total;
                                                        }
                                                    }),
                                                DatePicker::make('date')->required()
                                                ->minDate(Carbon::parse($record?->leavePointLatest?->current_month)->firstOfMonth())
                                                ->maxDate(Carbon::parse($record?->leavePointLatest?->current_month)->lastOfMonth())->native(false),
                                                Textarea::make('remarks')->label('remarks')->required()
                                            ])
                                            ->columns(2)
                                    ])->columns(1),
                                Fieldset::make('month')->label('Monthly Earn')->schema([
                                    TextInput::make('vl_earn')->step('any')->numeric()->default(1.25),
                                            TextInput::make('sl_earn')->step('any')->numeric()->default(1.25),
                                ])


                            ];
                        })
                        ->icon('heroicon-o-exclamation-circle')
                        ->action(function ($data, $record) {
                            try {
                                DB::beginTransaction();
                                $sorted = collect($data['L/UT'])->sortBy('date')->values()->all();

                                $currentMonth = Carbon::parse($record?->leavePointLatest?->current_month);
                                $newCurrentMonth = Carbon::parse($record?->leavePointLatest?->current_month)->addMonth();

                                $advanceSetting = \App\Models\Leave\LeaveAdvanceSetting::query()->where('id', 1)->first();

                                foreach ($sorted as $key => $value) {
                                    [$day, $hour, $min] = explode('-', $value['particular']);
                                    $total = $advanceSetting['days' . (int)$day] + $advanceSetting['hours' . (int)$hour] + $advanceSetting['min' . (int)$min];
                                    $record->leavePointLatest->update([
                                        'vl' => (float)$record->leavePointLatest?->vl - $total
                                    ]);
                                    \App\Models\Leave\LeaveCard::query()
                                        ->create([
                                            'start_date' => Carbon::parse($value['date']),
                                            'days' => str_pad($day, 2, '0', STR_PAD_LEFT),
                                            'hours' => $hour,
                                            'mins' => $min,
                                            'w_pay' => $total,
                                            'type' => "L/UT",
                                            'remarks' => $value['remarks'],
                                            'vl_balance' => $record->leavePointLatest?->vl,
                                            'sl_balance' => $record->leavePointLatest?->sl,
                                            'id_number' => $record->id_number
                                        ]);
                                }
                                \App\Models\Leave\LeaveCard::query()
                                    ->create([
                                        'start_date' => $currentMonth->lastOfMonth(),
                                        'period' => $currentMonth->format('F d, Y'),
                                        'days' => '00',
                                        'hours' => '00',
                                        'mins' => '00',
                                        'w_pay' => '00',
                                        'vl_earn' => $data['vl_earn'],
                                        'sl_earn' =>$data['sl_earn'],
                                        'type' => null,
                                        'remarks' => null,
                                        'vl_balance' => (float)$record->leavePointLatest?->vl + (float)$data['vl_earn'],
                                        'sl_balance' => (float)$record->leavePointLatest?->sl + (float)$data['sl_earn'],
                                        'id_number' => $record->id_number
                                    ]);



                                \App\Models\Leave\LeaveCard::query()
                                    ->create([
                                        'start_date' => $newCurrentMonth->firstOfMonth(),
                                        'period' => $newCurrentMonth->format('F Y'),
                                        'days' => '00',
                                        'hours' => '00',
                                        'mins' => '00',
                                        'w_pay' => '00',
                                        'type' => null,
                                        'remarks' => null,

                                        'id_number' => $record->id_number
                                    ]);
                                         $record?->leavePointLatest->update([
                                    'current_month' => $newCurrentMonth->format('F Y'),
                                    'vl' => (float)$record->leavePointLatest?->vl + (float)$data['sl_earn'],
                                    'sl' => (float)$record->leavePointLatest?->sl + (float)$data['sl_earn'],
                                ]);
                                DB::commit();
                            } catch (\Exception $e) {
                                DB::rollBack();
                            }
                        })->stickyModalHeader()->stickyModalFooter(),
                    Action::make('upload offline Leave Form')
                        ->label('UPLOAD OFFLINE LEAVE FORM')
                        ->icon('heroicon-o-academic-cap')
                        ->form([
                            TextInput::make('subject_title')->label('Title/Subject')->required(),
                            Select::make('type_of_leave')->required()
                                ->label(new HtmlString("TYPE OF LEAVE <span class='text-red-500'>(required)</span>"))
                                ->options(function () {
                                    $arr = [];
                                    foreach (\App\Enums\TypeOfLeaveEnum::cases() as $key => $d) {
                                        $arr[$d->value] = $d->value;
                                    }
                                    return $arr;
                                })
                                ->validationMessages([
                                    'required' => 'The Type of Leave field is required.',
                                ])
                                ->columnSpanFull()
                                ->rules('required')
                                ->reactive(),
                            DatePicker::make('start_date')->label('Applied Date')->required(),
                            TextInput::make('paid_days')->label('NUMBER OF WORKING DAYS')->numeric()->required(),
                            Textarea::make('remarks')->placeholder('Dec 20,21,21 2024')->required(),
                            FileUpload::make('attachment')
                                ->directory(Carbon::now()->format('Y') . '/leave/offline')
                                ->acceptedFileTypes(['application/pdf'])->required()
                        ])
                        ->action(function ($data, $record) {

                            $start = Carbon::parse($data['start_date'])->format('F Y');


                            // $startMonth = $now->firstOfMonth();
                            $startMonth = Carbon::parse($data['start_date']);
                            $arr['subject_title'] = $data['subject_title'];
                            $arr['days'] = $data['paid_days'];
                            $arr['id_number'] = $record->id_number;

                            $arr['status'] = \App\Enums\LeaveStatusEnum::APPROVED->value;
                            $arr['type_of_leave'] = $data['type_of_leave'];
                            $arr['type_of_process'] = "offline";
                            $arr['original_file'] = $data['attachment'];

                            // if ($data['type_of_leave'] == \App\Enums\TypeOfLeaveEnum::OTHERS->value) {
                            //     $arr['others'] = $arr['other_leave'];
                            // }

                            $leaveId = \App\Models\LeaveEmployeeRequest::create($arr);

                            if ($data['type_of_leave'] == \App\Enums\TypeOfLeaveEnum::SICK_LEAVE->value) {
                                $record->leavePointLatest->update([
                                    'sl' => (float)$record->leavePointLatest?->sl - (float)$data['paid_days']
                                ]);

                                \App\Models\Leave\LeaveCard::query()
                                    ->create([
                                        'start_date' => $startMonth,
                                        'days' => str_pad($data['paid_days'], 2, '0', STR_PAD_LEFT),
                                        'hours' => "00",
                                        'mins' => "00",
                                        'w_pay' => $data['paid_days'],
                                        'type' => "SL",
                                        'remarks' => $data['remarks'],
                                        'vl_balance' => $record->leavePointLatest?->vl,
                                        'sl_balance' => $record->leavePointLatest?->sl,
                                        'id_number' => $record->id_number
                                    ]);
                            } else if ($data['type_of_leave'] == \App\Enums\TypeOfLeaveEnum::FORCE_LEAVE->value) {
                                $record->leavePointLatest->update([
                                    'vl' => (float)$record->leavePointLatest?->vl - (float)$data['paid_days'],
                                    'fl' => (float)$record->leavePointLatest?->fl - (float)$data['paid_days'],
                                ]);


                                \App\Models\Leave\LeaveCard::query()
                                    ->create([
                                        'start_date' => $startMonth,
                                        'days' => str_pad($data['paid_days'], 2, '0', STR_PAD_LEFT),
                                        'hours' => "00",
                                        'mins' => "00",
                                        'w_pay' => $data['paid_days'],
                                        'type' => "FL",
                                        'remarks' => $data['remarks'],
                                        'vl_balance' => $record->leavePointLatest?->vl,
                                        'sl_balance' => $record->leavePointLatest?->sl,
                                        'id_number' => $record->id_number
                                    ]);
                            } else if ($data['type_of_leave'] == \App\Enums\TypeOfLeaveEnum::VACATION_LEAVE->value) {
                                $record->leavePointLatest->update([
                                    'vl' => (float)$record->leavePointLatest?->vl - (float)$data['paid_days']
                                ]);


                                \App\Models\Leave\LeaveCard::query()
                                    ->create([
                                        'start_date' => $startMonth,
                                        'days' => str_pad($data['paid_days'], 2, '0', STR_PAD_LEFT),
                                        'hours' => "00",
                                        'mins' => "00",
                                        'w_pay' => $data['paid_days'],
                                        'type' => "VL",
                                        'remarks' => $data['remarks'],
                                        'vl_balance' => $record->leavePointLatest?->vl,
                                        'sl_balance' => $record->leavePointLatest?->sl,
                                        'id_number' => $record->id_number
                                    ]);
                            } else if ($data['type_of_leave'] == \App\Enums\TypeOfLeaveEnum::SPECIAL_PRIVILEGE_LEAVE->value) {
                                $record->leavePointLatest->update([
                                    'spl' => (float)$record->leavePointLatest?->spl - (float)$data['paid_days']
                                ]);


                                \App\Models\Leave\LeaveCard::query()
                                    ->create([
                                        'start_date' => $startMonth,
                                        'days' => str_pad($data['paid_days'], 2, '0', STR_PAD_LEFT),
                                        'hours' => "00",
                                        'mins' => "00",
                                        'type' => "SPL",
                                        'remarks' => $data['remarks'],
                                        'vl_balance' => $record->leavePointLatest?->vl,
                                        'sl_balance' => $record->leavePointLatest?->sl,
                                        'id_number' => $record->id_number
                                    ]);
                            } else if ($data['type_of_leave'] == \App\Enums\TypeOfLeaveEnum::OTHERS->value && $record->others == 'CTO') {

                                $i = (int)$data['paid_days'];
                                foreach ($record->employeeInfo?->leavePointLatestCto as $cto) {

                                    if ($i > 0) {

                                        if ((float)$cto->points > 0) {
                                            while ($i > 0 && (float)$cto->points > 0) {
                                                if ((float)$cto->points > 0) {

                                                    $cto->update([
                                                        'points' => (float)$cto->points - 1
                                                    ]);
                                                }
                                                $i--;
                                            }
                                        }
                                    }
                                }

                                \App\Models\Leave\LeaveCard::query()
                                    ->create([
                                        'start_date' => $startMonth,
                                        'w_pay' => $data['paid_days'],
                                        'days' => str_pad($data['paid_days'], 2, '0', STR_PAD_LEFT),
                                        'hours' => "00",
                                        'mins' => "00",
                                        'type' => "CTO",
                                        'remarks' => $data['remarks'],
                                        'cto_balance' => $record->employeeInfo?->leavePointLatestCto->sum('points'),
                                        'id_number' => $record->id_number
                                    ]);
                            }
                        }),
                    Action::make('Leave Dashboard')
                        ->label('LEAVE DASHBOARD')
                        ->url(function ($record) {
                            $slug = str_replace(' ', '_', $record->name);
                            $slug = Str::upper($slug);

                            return route('leave.employees.view', ['employee_name' => $slug, 'employee_id' => $record->id_number]);
                        })->icon('heroicon-o-computer-desktop')
                ])


            ]);
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
                            $arr =  $date->format('h:i A');
                        }
                    } catch (\InvalidArgumentException $e) {
                        // If the date is not parsable, you can handle the error
                        $type = gettype($sheet->getCell($column)->getValue());


                        if ($type == 'double') {

                            $hours = $sheet->getCell($column)->getValue() * 24;
                            $minutes = ($hours - (int)$hours) * 60; // This will give you approximately 1.00000000000002

                            $time = Carbon::createFromTime((int)$hours, round($minutes));
                            $arr = $time->format('h:i A');
                        } else {
                            $arr = '';
                        }
                    }
                } else {


                    $arr = '';
                }
            }
        } else {
            if (!!$sheet->getCell($column)->getValue()) {
                try {
                    $type = gettype($sheet->getCell($column)->getValue());

                    if ($type == 'double') {

                        $hours = $sheet->getCell($column)->getValue() * 24;
                        $minutes = ($hours - (int)$hours) * 60; // This will give you approximately 1.00000000000002
                        $time = Carbon::createFromTime((int)$hours, round($minutes));
                        $arr = $time->format('h:i A');
                    } else {
                        $date = Carbon::createFromFormat('h:i A', $sheet->getCell($column)->getValue());
                        $arr =  $date->format('h:i A');
                    }
                } catch (\InvalidArgumentException $e) {

                    $type = gettype($sheet->getCell($column)->getValue());


                    if ($type == 'double') {

                        $hours = $sheet->getCell($column)->getValue() * 24;
                        $minutes = ($hours - (int)$hours) * 60; // This will give you approximately 1.00000000000002

                        $time = Carbon::createFromTime((int)$hours, round($minutes));
                        $arr = $time->format('h:i A');
                    } else {
                        $arr = '';
                    }
                }
            } else {


                $arr = '';
            }
        }
        return $arr;
    }
    function getAllDaysInMonth($year, $month): array
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
    public function render()
    {


        return view('livewire.leave.employees');
    }
}
