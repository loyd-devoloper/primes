<?php

namespace App\Traits\Leave;

use App\Models\OfficeCode;

use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;


trait LeaveRequestTrait
{

    // LEAVE REQUEST FORM STORE
    public function leaveRequestFormStore($availableFd): array
    {
        return [

            TextInput::make('subject_title')
                ->label(new HtmlString("SUBJECT/TITLE <span class='text-red-500'>(required)</span>"))
                ->validationMessages([
                    'required' => 'The Subject/Title field is required.',
                ])
                ->columnSpanFull()->rules('required'),
            Select::make('type_of_process')
                ->label(new HtmlString("TYPE OF PROCESS<span class='text-red-500'>(required)</span>"))
                ->options([
                    'WET SIGNATURE' => 'WET SIGNATURE',
                    'ELECTRONIC SIGNATURE' => 'ELECTRONIC SIGNATURE',
                ])
                ->rules('required')
                ->columnSpanFull()
                ->default('WET SIGNATURE')
                ->live(),
            Select::make('type_of_leave')
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
                ->reactive()
                ->helperText(function (Get $get, Set $set) {
                    $label = '';
                    if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::VACATION_LEAVE->value) {
                        $vl = $this->leaves?->vl;
                        $startDate = Carbon::now(); // Current date
                        $min = $this->addWeekdays($startDate, 5); // Add 5 weekdays
                        $this->x = $min;
                        $label = new HtmlString("Available Vacation Leave Points: <strong> $vl</strong>");
                    } elseif ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::SICK_LEAVE->value) {
                        $sl = $this->leaves?->sl;

                        $this->x = '1999-11-20';
                        $label = new HtmlString("Available Sick Leave Points: <strong> $sl</strong>");
                    } elseif ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::SPECIAL_PRIVILEGE_LEAVE->value) {
                        $spl = $this->leaves?->spl;
                        $this->x = '1999-11-20';
                        $label = new HtmlString("Available Special Privilege Leave Points: <strong> $spl</strong>");
                    } elseif ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::FORCE_LEAVE->value) {
                        $fl = $this->leaves?->fl;
                        $startDate = Carbon::now(); // Current date
                        $min = $this->addWeekdays($startDate, 5); // Add 5 weekdays
                        $this->x = $min;
                        $label = new HtmlString("Available Force Leave Points: <strong> $fl</strong>");
                    } elseif ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::OTHERS->value && Str::upper($get('other_leave')) == 'CTO') {
                        $cto = $this->leaveCto;
                        $this->x = Carbon::now()->format('Y-m-d');
                        $label = new HtmlString("Available CTO Points: <strong> $cto</strong>");
                    } else {
                        $this->x = Carbon::now()->format('Y-m-d');
                    }
                    return $label;
                }),

            TextInput::make('other_leave')
                ->label(new HtmlString("OTHERS <span class='text-red-500'>(required)</span>"))
                ->datalist([
                    'CTO',
                    'MONETIZATION'
                ])
                ->hidden(fn(Get $get) => $get('type_of_leave') == 'Others' ? false : true)
                ->live()
                ->required()
                ->columnSpanFull()
                ->rules('required')
                ->reactive(),

            ViewField::make('date')
                ->label(function (Get $get) {
                    return new HtmlString("NUMBER OF WORKING DAYS<span class='text-red-500'>(required)</span>");
                })
                ->view('livewire.leave.asset.calendar_input')
                ->viewData([
                    'min' => $this->minDate(),
                    'max' => 5,
                ])
                ->rules('required')
                ->helperText(function ($component, Get $get, Set $set) use ($availableFd) {

                    //    dd($component->getMinDate());
                    $label = '';
                    if (!!$get('date')) {
                        $this->notpaid = 0;
                        $this->paid = 0;
                        $number = count(explode(',', $get('date')));
                        $vl = (float)$this->leaves?->vl;
                        $sl = (float)$this->leaves?->sl;
                        $spl = (float)$this->leaves?->spl;
                        if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::FORCE_LEAVE->value) {
                            if ($number > $availableFd) {
                                Notification::make()
                                    ->title("Oops! You have $availableFd force leave available.")
                                    ->danger()
                                    ->persistent()
                                    ->send();
                                $this->notpaid = $number - (int)$availableFd;
                                $this->paid = (int)$availableFd;
                                $this->submitActionButton = true;
                            } else {
                                $this->notpaid = 0;
                                $this->paid = $number;
                                $this->submitActionButton = false;
                            }
                        }
                        if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::VACATION_LEAVE->value) {
                            if ($vl >= 1) {
                                $this->submitActionButton = false;
                                if ($number > $vl) {
                                    $this->notpaid = $number - (int)$vl;
                                    $this->paid = (int)$vl;
                                } else {
                                    $this->paid = $number;
                                }
                            } else {
                                $this->submitActionButton = true;
                            }
                        }
                        if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::SICK_LEAVE->value) {
                            if ($sl >= 1) {
                                $this->submitActionButton = false;
                                if ($number > $sl) {
                                    $this->notpaid = $number - (int)$sl;
                                    $this->paid = (int)$sl;
                                } else {
                                    $this->notpaid = 0;
                                    $this->paid = $number;
                                }
                            } else {
                                $this->submitActionButton = true;
                            }
                        }
                        if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::SPECIAL_PRIVILEGE_LEAVE->value) {
                            if ($spl >= 1) {
                                $this->submitActionButton = false;
                                if ($number > $spl) {
                                    $this->notpaid = $number - (int)$spl;
                                    $this->paid = (int)$spl;
                                } else {
                                    $this->notpaid = 0;
                                    $this->paid = $number;
                                }
                            } else {
                                $this->submitActionButton = true;
                            }
                        }
                        if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::OTHERS->value && Str::upper($get('other_leave')) == 'CTO') {

                            $countCto = \App\Models\LeaveEmployeeRequest::query()
                                ->where('others', 'CTO')
                                ->where('id_number', Auth::user()->id_number)
                                ->where('status', \App\Enums\LeaveStatusEnum::APPROVED->value)
                                ->get()
                                ->sum('paid_days');

                            if ($countCto == 15) {
                                Notification::make()
                                    ->title('NO REMAINING CTO BALANCE')
                                    ->duration(5000)
                                    ->danger()
                                    ->send();

                            } else {

                                $var = 15 - $countCto;

                                if ($var > 0) {
                                    if ($this->leaveCto >= 1) {
                                        $this->submitActionButton = false;

                                        if ($number > $this->leaveCto) {

                                            $this->notpaid = $number - (int)$this->leaveCto;
                                            $this->paid = (int)$this->leaveCto;
                                            if (((int)$this->leaveCto - $var) != 0) {

                                                Notification::make()
                                                    ->title("The available CTO this year is $var")
                                                    ->warning()
                                                    ->duration(5000)
                                                    ->send();
                                                $this->submitActionButton = true;
                                            }
                                        } else {

                                            $this->notpaid = 0;
                                            $this->paid = $number;


                                            if (($var - (int)$this->paid) < 0) {

                                                Notification::make()
                                                    ->title("The available CTO this year is $var")
                                                    ->warning()
                                                    ->duration(5000)
                                                    ->send();
                                                $this->submitActionButton = true;
                                            }else{
                                                $this->submitActionButton = false;
                                            }
                                        }


                                    } else {
                                        $this->submitActionButton = true;
                                    }

                                }
                            }


                        }
                        if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::OTHERS->value && Str::upper($get('other_leave')) == 'MONETIZATION') {

                            $this->submitActionButton = false;
                            $this->notpaid = 0;
                            $this->paid = $number;
                        }
                        $set('paid_days', $this->paid);
                        $set('notpaid_days', $this->notpaid);
                        $label = new HtmlString(" <div class='space-x-4'><span class='text-green-500'>PAID(<strong>$this->paid DAYS</strong>)</span> <span class='text-red-500'>NOTPAID(<strong>$this->notpaid DAYS</strong>)</span>  <span class='text-black dark:text-white'>TOTAL(<strong>$number DAYS</strong>)</span></div>");
                    }
                    return $label;
                })
                ->hidden(fn(Get $get) => !!$get('type_of_leave') ? false : true)
                ->validationMessages([
                    'required' => 'The date field is required.',
                ]),
            Hidden::make('paid_days'),
            Hidden::make('notpaid_days'),


            Fieldset::make('Process flow')
                ->schema([
                    Select::make('head_id')
                        ->label(new HtmlString("<strong>1. </strong> Chief of the Division/Section or Unit Head<span class='text-red-500'>(required)</span>"))
                        ->options(User::select('name','id_number')->get()->pluck('name', 'id_number'))

                        ->validationMessages([
                            'required' => 'The head field is required.',
                        ])->columnSpanFull()->rules('required')->searchable(),
                    Grid::make([
                        'default' => 2,
                        'sm' => 1,
                        'md' => 2
                    ])->schema([
                        Select::make('chief_id')
                            // ->label(new HtmlString("<strong>2. </strong>Chief Administrative Officer<span class='text-red-500'>(required)</span>"))
                            ->label(function (Get $get) {
                                $label = $get('chief_type');
                                return new HtmlString("<strong>2. </strong> $label<span class='text-red-500'>(required)</span>");
                            })
                            ->options(User::select('name','id_number')->get()->pluck('name', 'id_number'))
                            ->required()->rules('required')
                            ->searchable(),
                        Select::make('chief_type')
                            ->label(' ')
                            ->options([
                                'Chief Administrative Officer' => 'Chief Administrative Officer',
                                'Supervising Administrative Officer' => 'Supervising Administrative Officer',
                            ])
                            ->required()
                            ->rules('required')
                            ->searchable()
                            ->reactive()
                            ->default('Chief Administrative Officer'),
                    ]),
                    Grid::make([
                        'default' => 2,
                        'sm' => 1,
                        'md' => 2
                    ])->schema([
                        Select::make('rd_id')
                            ->label(function (Get $get) {
                                $label = $get('rd_type');
                                return new HtmlString("<strong>3. </strong> $label<span class='text-red-500'>(required)</span>");
                            })
                            ->options(User::select('name','id_number')->get()->pluck('name', 'id_number'))
                            ->required()
                            ->rules('required')
                            ->searchable(),
                        Select::make('rd_type')
                            ->label(' ')
                            ->options([
                                'Regional Director' => 'Regional Director',
                                'Assistant Regional Director' => 'Assistant Regional Director',
                            ])
                            ->reactive()
                            ->required()->rules('required')
                            ->searchable()
                            ->default('Regional Director'),
                    ]),

                ]),

        ];
    }

    // LEAVE REQUEST FORM EDIT

    function addWeekdays($date, $daysToAdd)
    {
        $currentDate = $date;
        $addedDays = 0;

        while ($addedDays < $daysToAdd) {
            $currentDate->addDay(); // Move to the next day
            // Check if the current day is a weekday (Monday to Friday)
            if ($currentDate->isWeekday()) {
                $addedDays++;
            }
        }

        return $currentDate->format('Y-m-d');
    }

    // disabled weekends

    public function convertDate($dates): string
    {
        $i = 1;
        $formattedDates = [];
        $previousMonth = '';
        foreach ($dates as $date) {
            // $newDate = Carbon::parse( $date);
            // if (!!$previousMonth) {
            //     if($newDate->isSameMonth(Carbon::parse($previousMonth)))
            //     {
            //         $formattedDates[] =  Carbon::parse($date)->format('j Y');
            //     }else{
            //         $i = 1;
            //         $formattedDates[] = $i == 1 ? Carbon::parse($date)->format('M j Y') : Carbon::parse($date)->format('j Y');
            //     }
            // }else{
            $formattedDates[] = true ? Carbon::parse($date)->format('M j Y') : Carbon::parse($date)->format('j Y'); // Format to "Nov 12"
            // }

            // $i++;
            // $previousMonth = $date;
        }
        $groupedByYear = [];

        // Iterate through each date in the array
        foreach ($formattedDates as $date) {
            // Extract the year from the date string
            $parts = explode(' ', $date);
            $year = end($parts); // Get the last element, which is the year

            // Remove the year from the date string for grouping
            $dateWithoutYear = trim(str_replace($year, '', $date));

            // Group by year
            if (!isset($groupedByYear[$year])) {
                $groupedByYear[$year] = []; // Initialize the array for this year if it doesn't exist
            }
            $groupedByYear[$year][] = trim($dateWithoutYear); // Add the date to the corresponding year
        }

        // Output the grouped array
        // Initialize an array to hold the formatted strings
        $formattedStrings = [];

        // Iterate over each year and its corresponding dates
        foreach ($groupedByYear as $year => $dates) {
            $formattedDates = [];
            $lastMonth = '';

            foreach ($dates as $date) {
                // Extract the month and day
                list($month, $day) = explode(' ', $date);

                // If the month is the same as the last one, only add the day
                if ($month === $lastMonth) {
                    $formattedDates[] = $day;
                } else {
                    $formattedDates[] = $date; // Keep the full date (month and day)
                    $lastMonth = $month; // Update the last month
                }
            }

            // Join the dates with a comma
            $datesString = implode(', ', $formattedDates);
            // Combine the dates with the year
            $formattedStrings[] = "$datesString $year";
        }

        // Join the formatted strings with " And "

        // Join the formatted strings with " And "
        $output = implode(' - ', $formattedStrings);
        return $output;
    }

    // ALL MY LEAVE TABLE ACTION

    public function myTabActions($availableFd): array
    {
        return [
            EditAction::make('Update')

                ->label('Update')
                ->icon('heroicon-o-pencil-square')
                ->color(Color::Green)
                ->mutateRecordDataUsing(function (array $data, $record): array {
                    // Decode the JSON string into a PHP array
                    $dateArray = json_decode($record?->date, true);
                    // Convert the array to a comma-separated string
                    $dateString = implode(', ', $dateArray);

                    $date = isset(json_decode($record?->date)[1]) ? json_decode($record?->date)[0] . " to " . json_decode($record?->date)[1] : json_decode($record?->date)[0];
                    $data['date'] = $dateString;
                    $data['other_leave'] = $record->others;

                    return $data;
                })
                ->form(function () use ($availableFd) {
                    return $this->leaveRequestFormEdit($availableFd);
                })
                ->modalWidth(MaxWidth::FitContent)
                ->hidden(fn($record) => \App\Enums\LeaveStatusEnum::PENDING->value == $record->status && $record->location == 'Head' ? false : true)
                ->action(function ($data, $record) {
                    $cleanedDates = str_replace(' ', '', $data['date']);
                    $data['date'] = $cleanedDates;
                    $data['date'] = explode(',', $data['date']);
                    $name = Auth::user()->name;
                    $oldFile = "/public/leave/$name/$record[original_file]";
                    usort($data['date'], function ($a, $b) {
                        return strtotime($a) - strtotime($b);
                    });
                    $data['others'] = isset($data['other_leave']) ? $data['other_leave'] : '';
                    // $record->original_file
                    $filename = $this->generateLeaveExcelFile($data);
                    $data['id_number'] = Auth::user()->id_number;
                    $data['date'] = json_encode($data['date']);
                    $data['status'] = \App\Enums\LeaveStatusEnum::PENDING->value;
                    $data['original_file'] = $filename;
                    $data['location'] = 'Head';

                    $record->update($data);


                    if (Storage::exists($oldFile)) {

                        Storage::delete($oldFile);
                    }
                    $name = Auth::user()->name;
                    \App\Models\LeaveRequestLogs::create([
                        'activity' => "$name Update this attachment",
                        'remarks' => '',
                        'location' => Auth::user()->user_fd_code?->division_name,
                        'id_number' => Auth::user()->id_number,
                        'leave_request_id' => $record->code,
                    ]);

                    Notification::make()
                        ->title('Updated successfully')
                        ->success()
                        ->send();
                }),
            Action::make('Request_information')
              ->hidden(function($record){

                            return $record->type_of_process == 'offline' ?? false;
                        })
                ->label('Request Information')
                ->icon('heroicon-o-document-magnifying-glass')
                ->color(Color::Gray)
                ->url(function ($record) {
                    $slug = str_replace(' ', '-', $record->subject_title);
                    $slug = Str::upper($slug);
                    return route('leave.request.view', ['request_id' => $record?->code, 'title' => $slug]);
                }),
            ViewAction::make('preview')
                ->label('preview')
                  ->hidden(function($record){

                            return $record->type_of_process == 'offline' ?? false;
                        })
                ->icon('heroicon-o-eye')
                ->color(Color::Blue)
                ->form(function ($record) {

                    $i = 1;
                    $formattedDates = [];

                    foreach (json_decode($record->date) as $date) {

                        $formattedDates[] = true ? Carbon::parse($date)->format('M j Y') : Carbon::parse($date)->format('j Y'); // Format to "Nov 12"

                    }
                    $groupedByYear = [];

                    // Iterate through each date in the array
                    foreach ($formattedDates as $date) {
                        // Extract the year from the date string
                        $parts = explode(' ', $date);
                        $year = end($parts); // Get the last element, which is the year

                        // Remove the year from the date string for grouping
                        $dateWithoutYear = trim(str_replace($year, '', $date));

                        // Group by year
                        if (!isset($groupedByYear[$year])) {
                            $groupedByYear[$year] = []; // Initialize the array for this year if it doesn't exist
                        }
                        $groupedByYear[$year][] = trim($dateWithoutYear); // Add the date to the corresponding year
                    }

                    // Output the grouped array
                    // Initialize an array to hold the formatted strings
                    $formattedStrings = [];

                    // Iterate over each year and its corresponding dates
                    foreach ($groupedByYear as $year => $dates) {
                        $formattedDates = [];
                        $lastMonth = '';

                        foreach ($dates as $date) {
                            // Extract the month and day
                            list($month, $day) = explode(' ', $date);

                            // If the month is the same as the last one, only add the day
                            if ($month === $lastMonth) {
                                $formattedDates[] = $day;
                            } else {
                                $formattedDates[] = $date; // Keep the full date (month and day)
                                $lastMonth = $month; // Update the last month
                            }
                        }

                        // Join the dates with a comma
                        $datesString = implode(', ', $formattedDates);
                        // Combine the dates with the year
                        $formattedStrings[] = "$datesString $year";
                    }


                    $output = implode(' - ', $formattedStrings);

                    // esign
                    $my_esign = \App\Models\LeaveEmployee::select('id_number', 'e_sign')->where('id_number', $record->id_number)->first();
                    return [
                        ViewField::make('rating')
                            ->view(
                                'livewire.leave.asset.previewForm6',
                                [

                                    'e_sign' => $my_esign?->e_sign,
                                    'inclusive_date' => $output
                                ]
                            )
                    ];
                })->modalWidth(MaxWidth::FitContent)
        ];
    }


    // my tab => actions

    public function leaveRequestFormEdit($availableFd): array
    {
        return [

            TextInput::make('subject_title')
                ->label(new HtmlString("SUBJECT/TITLE <span class='text-red-500'>(required)</span>"))
                ->validationMessages([
                    'required' => 'The Subject/Title field is required.',
                ])
                ->columnSpanFull()->rules('required'),
            Select::make('type_of_process')
                ->label(new HtmlString("TYPE OF PROCESS<span class='text-red-500'>(required)</span>"))
                ->options([
                    'WET SIGNATURE' => 'WET SIGNATURE',
                    'ELECTRONIC SIGNATURE' => 'ELECTRONIC SIGNATURE',
                ])
                ->rules('required')
                ->columnSpanFull()
                ->default('WET SIGNATURE')
                ->live(),

            Select::make('type_of_leave')
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
                ->reactive()
                ->helperText(function (Get $get, Set $set) {
                    $label = '';
                    if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::VACATION_LEAVE->value) {
                        $vl = $this->leaves?->vl;
                        $startDate = Carbon::now(); // Current date
                        $min = $this->addWeekdays($startDate, 5); // Add 5 weekdays
                        $this->x = $min;
                        $label = new HtmlString("Available Vacation Leave Points: <strong> $vl</strong>");
                    } elseif ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::SICK_LEAVE->value) {
                        $sl = $this->leaves?->sl;

                        $this->x = '20-11-1999';
                        $label = new HtmlString("Available Sick Leave Points: <strong> $sl</strong>");
                    } elseif ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::SPECIAL_PRIVILEGE_LEAVE->value) {
                        $spl = $this->leaves?->spl;
                        $this->x = '20-11-1999';
                        $label = new HtmlString("Available Special Privilege Leave Points: <strong> $spl</strong>");
                    } elseif ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::FORCE_LEAVE->value) {
                        $fl = $this->leaves?->fl;
                        $startDate = Carbon::now(); // Current date
                        $min = $this->addWeekdays($startDate, 5); // Add 5 weekdays
                        $this->x = $min;
                        $label = new HtmlString("Available Force Leave Points: <strong> $fl</strong>");
                    } elseif ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::OTHERS->value) {
                        $cto = $this->leaveCto;
                        $this->x = Carbon::now()->format('d-m-Y');
                        $label = new HtmlString("Available CTO Points: <strong> $cto</strong>");
                    } else {
                        $this->x = Carbon::now()->format('d-m-Y');
                    }
                    return $label;
                }),

            TextInput::make('other_leave')
                ->label(new HtmlString("OTHERS <span class='text-red-500'>(required)</span>"))
                ->hidden(fn(Get $get) => $get('type_of_leave') == 'Others' ? false : true)->live()->required()->columnSpanFull()->rules('required')->reactive(),
            // DatePicker::make('date_of_birth')
            // ->native(false)
            // ->minDate(fn(Get $get) => Carbon::parse($get('token')))
            // ->disabledDates($this->disabledWeekEnds()),
            ViewField::make('date')
                ->label(function (Get $get) {
                    return new HtmlString("NUMBER OF WORKING DAYS<span class='text-red-500'>(required)</span>");
                })
                ->view('livewire.leave.asset.calendar_input')
                ->viewData([
                    'min' => $this->minDate(),
                    'max' => 5,
                ])
                ->rules('required')
                ->helperText(function ($component, Get $get, Set $set) use ($availableFd) {

                    //    dd($component->getMinDate());
                    $label = '';
                    if (!!$get('date')) {
                        $this->notpaid = 0;
                        $this->paid = 0;
                        $number = count(explode(',', $get('date')));
                        $vl = (float)$this->leaves?->vl;
                        $sl = (float)$this->leaves?->sl;
                        $spl = (float)$this->leaves?->spl;
                        if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::FORCE_LEAVE->value) {
                            if ($number > $availableFd) {
                                Notification::make()
                                    ->title("Oops! You have $availableFd force leave available.")
                                    ->danger()
                                    ->persistent()
                                    ->send();
                                $this->notpaid = $number - $availableFd;
                                $this->paid = $availableFd;
                                $this->submitActionButton = true;
                            } else {
                                $this->notpaid = 0;
                                $this->paid = $number;
                                $this->submitActionButton = false;
                            }
                        }
                        if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::VACATION_LEAVE->value) {
                            if ($vl > 0) {
                                $this->submitActionButton = false;
                                if ($number > $vl) {
                                    $this->notpaid = $number - $vl;
                                    $this->paid = $vl;
                                } else {
                                    $this->paid = $number;
                                }
                            } else {
                                $this->submitActionButton = true;
                            }
                        }
                        if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::SICK_LEAVE->value) {
                            if ($sl > 0) {
                                $this->submitActionButton = false;
                                if ($number > $sl) {
                                    $this->notpaid = $number - $sl;
                                    $this->paid = $sl;
                                } else {
                                    $this->notpaid = 0;
                                    $this->paid = $number;
                                }
                            } else {
                                $this->submitActionButton = true;
                            }
                        }
                        if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::SPECIAL_PRIVILEGE_LEAVE->value) {
                            if ($spl > 0) {
                                $this->submitActionButton = false;
                                if ($number > $spl) {
                                    $this->notpaid = $number - $spl;
                                    $this->paid = $spl;
                                } else {
                                    $this->notpaid = 0;
                                    $this->paid = $number;
                                }
                            } else {
                                $this->submitActionButton = true;
                            }
                        }
                        if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::OTHERS->value && $get('other_leave') == 'CTO') {

                            if ($this->leaveCto > 0) {
                                $this->submitActionButton = false;
                                if ($number > $this->leaveCto) {
                                    $this->notpaid = $number - $this->leaveCto;
                                    $this->paid = $this->leaveCto;
                                } else {
                                    $this->notpaid = 0;
                                    $this->paid = $number;
                                }
                            } else {
                                $this->submitActionButton = true;
                            }
                        }
                        $set('paid_days', $this->paid);
                        $set('notpaid_days', $this->notpaid);
                        $label = new HtmlString(" <div class='space-x-4'><span class='text-green-500'>PAID(<strong>$this->paid DAYS</strong>)</span> <span class='text-red-500'>NOTPAID(<strong>$this->notpaid DAYS</strong>)</span>  <span class='text-black dark:text-white'>TOTAL(<strong>$number DAYS</strong>)</span></div>");
                    }
                    return $label;
                })
                ->hidden(fn(Get $get) => !!$get('type_of_leave') ? false : true)
                ->validationMessages([
                    'required' => 'The date field is required.',
                ]),
            // Flatpickr::make('date')
            //     ->multiple()
            //     ->label(function (Get $get) {
            //         return new HtmlString("NUMBER OF WORKING DAYS<span class='text-red-500'>(required)</span>");
            //     })
            //     ->altFormat('F j, Y')
            //     ->showMonths(2)
            //     ->rules('required')
            //     ->reactive()
            //     // ->minDate(Carbon::parse($this->x))
            //     ->validationMessages([
            //         'required' => 'The date field is required.',
            //     ])
            //     ->helperText(function ($component,Get $get, Set $set) use ($availableFd) {

            //     //    dd($component->getMinDate());
            //         $label = '';
            //         if (!!$get('date')) {
            //             $this->notpaid = 0;
            //             $this->paid = 0;
            //             $number = count(explode(',', $get('date')));
            //             $vl = (float)$this->leaves?->vl;
            //             $sl = (float)$this->leaves?->sl;
            //             $spl = (float)$this->leaves?->spl;
            //             if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::FORCE_LEAVE->value) {
            //                 if ($number > $availableFd) {
            //                     Notification::make()
            //                         ->title("Oops! You have $availableFd force leave available.")
            //                         ->danger()

            //                         ->persistent()
            //                         ->send();
            //                     $this->notpaid = $number - $availableFd;
            //                     $this->paid =  $availableFd;
            //                     $this->submitActionButton = true;
            //                 } else {
            //                     $this->notpaid = 0;
            //                     $this->paid = $number;
            //                     $this->submitActionButton = false;
            //                 }
            //             }
            //             if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::VACATION_LEAVE->value) {
            //                 if ($vl > 0) {
            //                     $this->submitActionButton = false;
            //                     if ($number > $vl) {
            //                         $this->notpaid = $number - $vl;
            //                         $this->paid =  $vl;
            //                     } else {
            //                         $this->paid = $number;
            //                     }
            //                 } else {
            //                     $this->submitActionButton = true;
            //                 }
            //             }
            //             if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::SICK_LEAVE->value) {
            //                 if ($sl > 0) {
            //                     $this->submitActionButton = false;
            //                     if ($number > $sl) {
            //                         $this->notpaid = $number - $sl;
            //                         $this->paid =  $sl;
            //                     } else {
            //                         $this->notpaid = 0;
            //                         $this->paid = $number;
            //                     }
            //                 } else {
            //                     $this->submitActionButton = true;
            //                 }
            //             }
            //             if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::SPECIAL_PRIVILEGE_LEAVE->value) {
            //                 if ($spl > 0) {
            //                     $this->submitActionButton = false;
            //                     if ($number > $spl) {
            //                         $this->notpaid = $number - $spl;
            //                         $this->paid =  $spl;
            //                     } else {
            //                         $this->notpaid = 0;
            //                         $this->paid = $number;
            //                     }
            //                 } else {
            //                     $this->submitActionButton = true;
            //                 }
            //             }
            //             if ($get('type_of_leave') == \App\Enums\TypeOfLeaveEnum::OTHERS->value && $get('other_leave') == 'CTO') {

            //                 if ($this->leaveCto > 0) {
            //                     $this->submitActionButton = false;
            //                     if ($number > $this->leaveCto) {
            //                         $this->notpaid = $number - $this->leaveCto;
            //                         $this->paid =  $this->leaveCto;
            //                     } else {
            //                         $this->notpaid = 0;
            //                         $this->paid = $number;
            //                     }
            //                 } else {
            //                     $this->submitActionButton = true;
            //                 }
            //             }
            //             $set('paid_days', $this->paid);
            //             $set('notpaid_days', $this->notpaid);
            //             $label =  new HtmlString(" <div class='space-x-4'><span class='text-green-500'>PAID(<strong>$this->paid DAYS</strong>)</span> <span class='text-red-500'>NOTPAID(<strong>$this->notpaid DAYS</strong>)</span>  <span class='text-black'>TOTAL(<strong>$number DAYS</strong>)</span></div>");
            //         }
            //         return $label;
            //     })
            //     ->disabledDates($this->disabledWeekEnds()),
            Hidden::make('paid_days'),
            Hidden::make('notpaid_days'),


            Fieldset::make('Process flow')
                ->schema([
                    Select::make('head_id')
                        ->label(new HtmlString("<strong>1. </strong> Chief of the Division/Section or Unit Head<span class='text-red-500'>(required)</span>"))
                        ->options(User::select('name','id_number')->get()->pluck('name', 'id_number'))
                        ->validationMessages([
                            'required' => 'The head field is required.',
                        ])->columnSpanFull()->rules('required')->searchable(),
                    Grid::make([
                        'default' => 2,
                        'sm' => 1,
                        'md' => 2
                    ])->schema([
                        Select::make('chief_id')
                            // ->label(new HtmlString("<strong>2. </strong>Chief Administrative Officer<span class='text-red-500'>(required)</span>"))
                            ->label(function (Get $get) {
                                $label = $get('chief_type');
                                return new HtmlString("<strong>2. </strong> $label<span class='text-red-500'>(required)</span>");
                            })
                            ->options(User::select('name','id_number')->get()->pluck('name', 'id_number'))
                            ->required()->rules('required')
                            ->searchable(),
                        Select::make('chief_type')
                            ->label(' ')
                            ->options([
                                'Chief Administrative Officer' => 'Chief Administrative Officer',
                                'Supervising Administrative Officer' => 'Supervising Administrative Officer',
                            ])
                            ->required()
                            ->rules('required')
                            ->searchable()
                            ->reactive()
                            ->default('Chief Administrative Officer'),
                    ]),
                    Grid::make([
                        'default' => 2,
                        'sm' => 1,
                        'md' => 2
                    ])->schema([
                        Select::make('rd_id')
                            ->label(function (Get $get) {
                                $label = $get('rd_type');
                                return new HtmlString("<strong>3. </strong> $label<span class='text-red-500'>(required)</span>");
                            })
                            ->options(User::select('name','id_number')->get()->pluck('name', 'id_number'))
                            ->required()
                            ->rules('required')
                            ->searchable(),
                        Select::make('rd_type')
                            ->label(' ')
                            ->options([
                                'Regional Director' => 'Regional Director',
                                'Assistant Regional Director' => 'Assistant Regional Director',
                            ])
                            ->reactive()
                            ->required()->rules('required')
                            ->searchable()
                            ->default('Regional Director'),
                    ]),

                ]),

        ];
    }
}
