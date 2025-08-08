<?php

namespace App\Livewire\Leave;


use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;

use Carbon\CarbonPeriod;

use Filament\Tables\Table;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;


class EmployeesView extends Component implements HasActions, HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithActions;

    #[Url()]
    public $tab =  'LEAVE-REQUEST';
    public $employeeName = '';
    public $employee_id = '';
    public $ids = '';
    public $leaves = null;
    public $leaveCto = null;
    public $leavesData = [];
    public $leaveData = [];
    public $leaveDataCto = [];
    public $sl = '';
    public $vl = '';
    public $fl = '';
    public $spl = '';
    public $userInfos = [];

    public function mount($employee_name, $employee_id)
    {

        $this->employee_id = $employee_id;
        $slug = str_replace('_', ' ', $employee_name);
        $slug = strtolower($slug);
        $this->employeeName = $slug;


        $this->leaveData = \App\Models\Leave\LeaveCard::query()->where(function ($query) {
            $query->where('type', null)->orWhere('type', '!=', 'CTO');
        })->where('id_number', $this->employee_id)->get();

        $this->leaveDataCto = \App\Models\Leave\LeaveCard::query()->where(function ($query) {
            $query->where('type', null)->orWhere('type', '=', 'CTO');
        })->where('id_number', $this->employee_id)->get();

        $this->userInfos = \App\Models\UserInfo::query()
            ->where('id_number', $employee_id)->first();
    }
    public function changeTab($tab)
    {

        $this->resetPage();
        $this->deselectAllTableRecords();
        // $tab == 'LEAVE-REQUEST' ? sleep(1) : '';
        $this->tab = $tab;
    }

    public function logsTable($old, $new): string
    {
        return " <div class='flex items-center gap-5 dark:text-white'>
        <div class='grid max-w-max'>
            <h1 class='border-2 border-black dark:border-white text-center px-10 py-2  rounded-t-md   font-bold'>Before</h1>
            <div class='border-x-2 border-b-2 border-black dark:border-white  px-10 py-2  '>
                $old points
            </div>
        </div>
        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' class='size-6  text-black dark:text-white'>
            <path fill-rule='evenodd'
                d='M16.72 7.72a.75.75 0 0 1 1.06 0l3.75 3.75a.75.75 0 0 1 0 1.06l-3.75 3.75a.75.75 0 1 1-1.06-1.06l2.47-2.47H3a.75.75 0 0 1 0-1.5h16.19l-2.47-2.47a.75.75 0 0 1 0-1.06Z'
                clip-rule='evenodd' />
        </svg>

        <div class='grid max-w-max'>
            <h1 class='border-2 border-black dark:border-white text-center px-10 py-2  rounded-t-md   font-bold'>After</h1>
            <div class='border-x-2 border-b-2 border-black dark:border-white  px-10 py-2  '>
                $new points
            </div>
        </div>
    </div>";
    }
    // leave card
    public function slideOverLeaveCardAction()
    {
        return \Filament\Actions\Action::make('slideOverLeaveCard')
            ->label('Leave Card')
            ->icon('heroicon-m-arrow-down-on-square')
            ->color(Color::Red)
            ->size('sm')
            ->requiresConfirmation()
            ->action(function ($data) {

                $name = Auth::user()->name;

                \App\Models\Leave\LeaveEmployeeActivityLog::create([
                    'activity' => "$name Download Leave Card",
                    'remarks' =>  "",
                    'location' => Auth::user()->user_fd_code?->division_name,
                    'employee_leave_id' => $this->employee_id,
                    'id_number' => Auth::user()->id_number,
                ]);

                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('livewire.leave.asset.leave_card', ['leaveData' => $this->leaveData, 'name' => $this->employeeName, 'userInfo' => $this->userInfos])->setPaper('a4', 'landscape');
                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf->stream();
                },  "$this->employeeName - Leave Card.pdf");
            });
    }
    // Download leave card CTO
    public function slideOverLeaveCardCtoAction()
    {
        return \Filament\Actions\Action::make('slideOverLeaveCardCto')
            ->label('CTO Card')
            ->icon('heroicon-m-arrow-down-on-square')
            ->color(Color::Amber)
            ->size('sm')
            ->requiresConfirmation()
            ->action(function ($data) {
                $name = Auth::user()->name;
                \App\Models\Leave\LeaveEmployeeActivityLog::create([
                    'activity' => "$name Download Leave Card - CTO Card",
                    'remarks' =>  "",
                    'location' => Auth::user()->user_fd_code?->division_name,
                    'employee_leave_id' => $this->employee_id,
                    'id_number' => Auth::user()->id_number,
                ]);

                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('livewire.leave.asset.leave_card_cto', ['leaveData' => $this->leaveDataCto, 'name' => $this->employeeName, 'userInfo' => $this->userInfos])->setPaper('a4', 'landscape');
                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf->stream();
                },  "$this->employeeName - Leave Card - CTO.pdf");
            });
    }
    // ADD NEW CTO
    public function slideOverCtoAction()
    {
        return \Filament\Actions\Action::make('slideOverCto')
            ->label('Add CTO')
            ->icon('heroicon-m-plus')
            ->color(Color::Gray)
            ->size('sm')
            ->form([
                TextInput::make('subject')->required(),
                TextInput::make('points')->numeric()->required()->step('any'),
                DatePicker::make('effective_date')->label('Effectivity Date')->required(),
                FileUpload::make('attachment')
                    ->directory('leave/bulkcto')
                    ->acceptedFileTypes(['application/pdf'])->required()
            ])
            ->slideOver()
            ->action(function ($data) {

                $expired = Carbon::parse($data['effective_date'])->addYear()->format('Y-m-d');
                $effective_date = Carbon::parse($data['effective_date'])->format('Y-m-d');
                $data['expired_date'] = $expired;
                $data['effective_date'] = $effective_date;
                $data['id_number'] = $this->employee_id;
                $data['status'] = \App\Enums\CtoStatusEnum::ACTIVE->value;
                $name = Auth::user()->name;
                $new = (float)$this->leaveCto + (float)$data['points'];
                $transaction = \App\Models\Leave\LeaveCto::create($data);
                \App\Models\Leave\LeaveEmployeeActivityLog::create([
                    'activity' => "$name Updated CTO Points",
                    'remarks' =>  $this->logsTable($this->leaveCto, $new),
                    'location' => Auth::user()->user_fd_code?->division_name,
                    'employee_leave_id' => $this->employee_id,
                    'id_number' => Auth::user()->id_number,
                ]);

                $now = Carbon::now();
                \App\Models\Leave\LeaveCard::query()
                    ->updateOrCreate([
                        'id_number' =>  $this->employee_id,
                        'request_id' => $transaction->id,
                    ], [
                        'particulars' => $data['subject'],
                        'start_date' => $now,

                        'type' => "CTO",
                        'remarks' => $effective_date,
                        'cto_balance' => $new,
                        'id_number' =>  $this->employee_id,
                        'vl_earn' => $data['points']
                    ]);
                Notification::make()
                    ->title('Created successfully')
                    ->success()
                    ->send();
                return redirect()->route('leave.employees.view', ['employee_id' => $this->employee_id, 'employee_name' => $this->employeeName, 'tab' => "UPDATE-LEAVE"]);
            });
    }

    // ADD NEW CTO
    public function slideOverNewLeaveAction()
    {
        return \Filament\Actions\Action::make('slideOverNewLeave')
            ->disabled($this->leaves?->status ?? false)
            ->label('Update Leave Credit')
            ->icon('heroicon-m-arrow-path')
            ->color(Color::Green)
            ->size('sm')
            ->form([

                TextInput::make('sl')->label('Sick Leave (SL)')->numeric()->required()->step('any')->helperText("Current Points: 1")->default($this->leaves?->sl),
                TextInput::make('vl')->label('Vacation Leave (VL)')->numeric()->required()->step('any')->helperText("Current Points: 1")->default($this->leaves?->vl),
                TextInput::make('fl')->label('Force Leave (FL)')->numeric()->required()->step('any')->helperText("Current Points: 1")->default($this->leaves?->fl),
                TextInput::make('spl')->label('Special Privilege Leave(SPL)')->numeric()->required()->step('any')->helperText("Current Points: 1")->default($this->leaves?->spl),
                Select::make('current_month')
                    ->label('Month')
                    ->options([
                        'January' => 'January',
                        'Febuary' => 'Febuary',
                        'March' => 'March',
                        'April' => 'April',
                        'May' => 'May',
                        'June' => 'June',
                        'July' => 'July',
                        'August' => 'August',
                        'September' => 'September',
                        'October' => 'October',
                        'November' => 'November',
                        'December' => 'December',
                    ])->required()->default($this->leaves?->current_month),


            ])
            ->action(function ($data, $record) {
                $employeeLeave = \App\Models\LeaveEmployee::updateOrCreate([
                    "id_number" => $this->employee_id
                ], [
                    "sl" => $data["sl"],
                    "vl" => $data["vl"],
                    "fl" => $data["fl"],
                    "spl" => $data["spl"],
                    "current_month" => $data["current_month"],
                    'status'=>0

                ]);
                Notification::make()
                    ->title('Updated successfully')
                    ->success()
                    ->send();
                return redirect()->route('leave.employees.view', ['employee_id' => $this->employee_id, 'employee_name' => $this->employeeName, 'tab' => "UPDATE-LEAVE"]);
            })
            ->slideOver();
    }
    // ADD LEAVE CREDITS
    public function modalFormAddAction()
    {
        return \Filament\Actions\Action::make('modalFormAdd')
            ->label("ADD")
            ->requiresConfirmation()
            ->color(Color::Green)
            ->action(function (array $arguments) {
                $employeeLeave = $this->leaves;

                if ($employeeLeave == null) {
                    $create = \App\Models\LeaveEmployee::query()
                        ->create([
                            'id_number' => $this->employee_id,
                            'sl' => 0,
                            'vl' => 0,
                            'fl' => 0,
                            'spl' => 0,
                            'status'=>0
                        ]);
                    $employeeLeave = \App\Models\LeaveEmployee::where('id_number', $this->employee_id)->first();
                }
                $name = Auth::user()->name;
                if ($arguments['label'] == $arguments['label']) {
                    $label = $arguments['label'];
                    $old = (float)$employeeLeave->$label;
                    if ($arguments['label'] == 'fl') {
                        if (($old + (float)$this->$label) > 5) {
                            $employeeLeave->update([
                                $label => 5
                            ]);
                        } else {
                            $employeeLeave->update([
                                $label => $old + (float)$this->$label
                            ]);
                        }
                    } else {
                        $employeeLeave->update([
                            $label => $old + (float)$this->$label
                        ]);
                    }


                    \App\Models\Leave\LeaveEmployeeActivityLog::create([
                        'activity' => "$name Update $arguments[fullLabel] Points",
                        'remarks' => $this->logsTable($old, $employeeLeave->$label),
                        'employee_leave_id' => $this->employee_id,
                        'location' => Auth::user()->user_fd_code?->division_name,
                        'id_number' => Auth::user()->id_number,
                    ]);
                    Notification::make()
                        ->title('Updated successfully')
                        ->success()
                        ->send();
                    return redirect()->route('leave.employees.view', ['employee_id' => $this->employee_id, 'employee_name' => $this->employeeName, 'tab' => "UPDATE-LEAVE"]);
                }
            })
            ->disabled(function ($arguments) {
                if ($arguments['label'] == 'sl') {
                    return !!$this->sl ? false : true;
                } else if ($arguments['label'] == 'vl') {
                    return !!$this->vl ? false : true;
                } else if ($arguments['label'] == 'fl') {
                    return !!$this->fl ? false : true;
                } else if ($arguments['label'] == 'spl') {
                    return !!$this->spl ? false : true;
                } else {
                    return false;
                }
            });
    }
    // minus LEAVE CREDITS
    public function modalFormMinusAction()
    {
        return \Filament\Actions\Action::make('modalFormMinus')
            ->label('Minus')
            ->requiresConfirmation()

            ->color(Color::Red)
            ->action(function ($data, $arguments) {
                $employeeLeave = \App\Models\LeaveEmployee::where('id_number', $this->employee_id)->first();
                if ($employeeLeave == null) {
                    $create = \App\Models\LeaveEmployee::create([
                        'id_number' => $this->employee_id,
                        'sl' => 0,
                        'vl' => 0,
                        'fl' => 0,
                        'spl' => 0,
                    ]);
                    $employeeLeave = \App\Models\LeaveEmployee::where('id_number', $this->employee_id)->first();
                }
                $name = Auth::user()->name;
                if ($arguments['label'] == $arguments['label']) {
                    $label = $arguments['label'];
                    $old = (float)$employeeLeave->$label;
                    if ($arguments['label'] == 'fl') {
                        if (($old - (float)$this->$label) < 1) {
                            $employeeLeave->update([
                                $label => 0
                            ]);
                        } else {
                            $employeeLeave->update([
                                $label => $old - (float)$this->$label
                            ]);
                        }
                    } else {
                        $employeeLeave->update([
                            $label => $old - (float)$this->$label
                        ]);
                    }

                    \App\Models\Leave\LeaveEmployeeActivityLog::create([
                        'activity' => "$name Update $arguments[fullLabel] Points",
                        'remarks' => $this->logsTable($old, $employeeLeave->$label),
                        'employee_leave_id' => $this->employee_id,
                        'location' => Auth::user()->user_fd_code?->division_name,
                        'id_number' => Auth::user()->id_number,
                        'type' => 2,
                    ]);
                    Notification::make()
                        ->title('Updated successfully')
                        ->success()
                        ->send();
                    return redirect()->route('leave.employees.view', ['employee_id' => $this->employee_id, 'employee_name' => $this->employeeName, 'tab' => "UPDATE-LEAVE"]);
                }
            })
            ->disabled(function ($arguments) {
                if ($arguments['label'] == 'sl') {
                    return !!$this->sl ? false : true;
                } else if ($arguments['label'] == 'vl') {
                    return !!$this->vl ? false : true;
                } else if ($arguments['label'] == 'fl') {
                    return !!$this->fl ? false : true;
                } else if ($arguments['label'] == 'spl') {
                    return !!$this->spl ? false : true;
                } else {
                    return false;
                }
            });
    }
    // SYNC LEAVE POINTS
    public function modalFormSyncAction()
    {

        return \Filament\Actions\Action::make('modalFormSync')
            ->disabled($this->leaves?->status ?? false)
            ->label('Sync')
            ->icon('heroicon-m-arrow-path')
            ->color(Color::Blue)
            ->size('sm')
            ->requiresConfirmation()
            ->action(function ($data) {
                $start = Carbon::parse($this->leaves->current_month)->format('F Y');


                // $startMonth = $now->firstOfMonth();
                $startMonth = Carbon::parse($this->leaves->current_month)->firstOfMonth();

                 \App\Models\LeaveEmployee::query()->where('id_number', $this->employee_id)->update([
                    'status' => 1
                ]);




                \App\Models\Leave\LeaveCard::query()
                    ->updateOrCreate(

                        [
                            'id_number' => $this->leaves?->id_number,
                            'period' => $start,
                            'vl_balance' => $this->leaves?->vl,
                            'sl_balance' =>  $this->leaves?->sl,
                            'cto_balance' =>  $this->leaves?->leavePointLatestCto?->sum('points'),
                        ],
                        [
                            'period' => $start,
                            'start_date' => $startMonth,
                            'id_number' => $this->leaves?->id_number,
                            'particulars' => "Balance Forwarded"
                        ]
                    );

                return redirect()->route('leave.employees.view', ['employee_id' => $this->employee_id, 'employee_name' => $this->employeeName, 'tab' => "UPDATE-LEAVE"]);
            });
    }
    public function convertDate($dates)
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
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\LeaveEmployeeRequest::query()
                ->with(['chiefInfo', 'headInfo', 'rdInfo', 'userInfo', 'workExperience'])
                ->where('id_number', $this->employee_id)->orderByDesc('id'))
            ->columns([
                TextColumn::make('code')->searchable(),
                TextColumn::make('subject_title')->searchable()->toggleable()->wrap()->extraAttributes(['style' => 'width: 20rem']),
                TextColumn::make('type_of_leave')->searchable()->toggleable()->state(function ($record) {
                    if ($record->type_of_leave == 'Others') {
                        return $record->others;
                    } else {
                        return $record->type_of_leave;
                    }
                }),
                TextColumn::make('date')
                    ->formatStateUsing(function ($state) {
                        $state = json_decode($state);
                        return $this->convertDate($state);
                    })->searchable()->toggleable(),
                TextColumn::make('type_of_process')->toggleable(),
                TextColumn::make('location')->toggleable(),
                IconColumn::make('head_status')->label('HEAD')->toggleable()->boolean(),
                IconColumn::make('chief_status')->label('CAO/SAO')->toggleable()->boolean(),
                IconColumn::make('rd_status')->label('RD/ARD')->toggleable()->boolean(),

                TextColumn::make('status')->color(fn($state) => \App\Enums\LeaveStatusEnum::tryFrom($state)?->getColor())
                    ->badge()->toggleable(),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('view Employee Information')
                        ->label('Attachment')
                          ->hidden(function ($record) {

                            return $record->type_of_process != 'offline' ?? false;
                        })
                        ->icon('heroicon-m-eye')
                        ->color(Color::Green)
                        ->form([
                              PdfViewerField::make('signed_file')
                                        //  ->hidden(!!$file ? false : true)
                                        ->label(false)
                                        ->fileUrl(function ($record)  {

                                            return !!$record?->original_file? Storage::url($record?->original_file) : "";
                                        })
                                        ->minHeight('80svh')


                        ])
                        ->modalSubmitAction(false)
                           ->modalCancelAction(false)
                              ->modalWidth(MaxWidth::ScreenExtraLarge),
                    // Action::make('Preview')
                    //     ->color(Color::Blue)
                    //     ->icon('heroicon-m-eye')

                    Action::make('Request_information')
                        ->hidden(function ($record) {

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
                    EditAction::make('preview')
                        ->hidden(function ($record) {

                            return $record->type_of_process == 'offline' ?? false;
                        })
                        ->label('preview')
                        ->icon('heroicon-o-eye')
                        ->color(Color::Blue)
                        ->form(function ($record) {
                            $startDate = Carbon::parse(json_decode($record->date)[0]);

                            if (array_key_exists('1', json_decode($record->date))) {
                                $endDate =  Carbon::parse(json_decode($record->date)[1]);

                                $period = CarbonPeriod::create($startDate, $endDate);

                                $number = 0;
                                foreach ($period as $date) {
                                    if ($date->isWeekday()) {

                                        $number++;
                                    }
                                }
                                $newDate = $startDate->format('F d, Y') . " - " . $endDate->format('F d, Y');
                            } else {
                                $number = 1;
                                $endDate = null;
                                $newDate = $startDate->format('F d, Y');
                            }
                            $days = $number == 1 ? "$number DAY" : "$number DAYS";

                            // esign
                            $my_esign = \App\Models\LeaveEmployee::select('id_number', 'e_sign')->where('id_number', $record->id_number)->first();
                            return [
                                ViewField::make('rating')
                                    ->view(
                                        'livewire.leave.asset.previewForm6',
                                        [
                                            'days' => $days,
                                            'newDate' => $newDate,
                                            'e_sign' => $my_esign?->e_sign,
                                            'total_vl' => (float)$this->leaves['vl'],
                                            'total_sl' => (float)$this->leaves['sl'],
                                            'less_vl' => $number,
                                            'less_sl' => $number,
                                            'balance_vl' => (float)$this->leaves['vl'] - (float)$number,
                                            'balance_sl' => (float)$this->leaves['sl'] - (float)$number,
                                        ]
                                    )
                            ];
                        })->modalWidth(MaxWidth::FitContent)
                ])->tooltip('Actions')
            ]);
    }

    public function render()
    {



        $employeeInfo = User::query()
            ->select('id_number', 'name', 'email', 'profile')

            ->with(['leavePointLatest', 'leavePointLatestCto', 'leaveActivityLogs'])->where('id_number', $this->employee_id)->first();

        $this->ids = $employeeInfo?->id_number;
        $this->leaves = $employeeInfo?->leavePointLatest;

        $this->leaveCto = $employeeInfo?->leavePointLatestCto?->sum('points');


        return view('livewire.leave.employees-view', compact('employeeInfo'))->title(Str::upper($this->employeeName));
    }
}
