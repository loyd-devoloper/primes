<?php

namespace App\Livewire\Leave;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;

use Carbon\CarbonPeriod;
use Filament\Tables\Table;

use Illuminate\Support\Str;
use Livewire\Attributes\Url;

use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Filament\Actions\StaticAction;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use App\Traits\Leave\AttachmentTrait;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use \App\Traits\Leave\LeaveRequestTrait;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\CreateAction;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;

class MyLeave extends Component implements HasActions, HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithActions;
    use AttachmentTrait;
    use LeaveRequestTrait;
    #[Url()]
    public $tab =  'LEAVE-REQUEST';
    public $leaves = null;
    public $leaveCto = 0;
    public $paid = 0;
    public $notpaid = 0;
    public $leaveData = '';
    public $activities = [];


    public $minDates = '';
    public $x = '';
    public $disabledDate = null;
    public $dtrData = [];

    // submit button
    public bool $submitActionButton = false;
    public function mount(): void
    {



        $this->leaveData = \App\Models\Leave\LeaveCard::where('id_number', Auth::user()->id_number)->orderBy('start_date', 'asc')->get();
        $this->activities = \App\Models\Leave\LeaveEmployeeActivityLog::where('id_number', Auth::user()->id_number)->get();

        $this->disabledDate = \App\Models\Leave\LeaveCalendar::select('start')->get()->toArray();
        $this->dtrData = \App\Models\Leave\LeaveBulkDtr::query()->where('id_number', Auth::user()->id_number)->latest()->get();

        $this->minDates = Carbon::now()->format('Y-m-d');
    }

    public function changeTab($tab)
    {

        $this->resetPage();
        $this->deselectAllTableRecords();
        // $tab == 'LEAVE-REQUEST' ? sleep(1) : '';
        $this->tab = $tab;
    }

    public function modalFormAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('modalForm')
            ->label('Update Leave')
            ->icon('heroicon-m-pencil-square')
            ->form([
                TextInput::make('sl')->prefix('Sick Leave')->label(false)->numeric()->step(2.2)->required()->rules('required'),
                TextInput::make('vl')->prefix('Vacation Leave')->label(false)->numeric()->step(2.2)->required()->rules('required'),
                TextInput::make('fl')->prefix('Force Leave')->label(false)->numeric()->step(2.2)->required()->rules('required'),
                TextInput::make('spl')->prefix('SPL')->label(false)->numeric()->step(2.2)->required()->rules('required'),
                TextInput::make('cto')->prefix('CTO')->label(false)->numeric()->step(2.2)->required()->rules('required'),
            ])
            ->color(Color::Green)
            ->slideOver()

            ->size('sm')
            ->action(function ($data) {
                \App\Models\LeaveEmployee::create($data);
                Notification::make()
                    ->title('Updated successfully')
                    ->success()
                    ->send();
            });
    }
    // log
    public function slideOverAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('slideOver')
            ->label('Activity Logs')
            ->icon('heroicon-m-clock')
            ->color(Color::Gray)
            ->size('sm')
            ->form([
                ViewField::make('rating')
                    ->view('livewire.leave.personnel.employee-logs')
                    ->viewData([
                        'activities' => $this->activities,

                    ])
            ])
            ->slideOver()
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Close')
            ->action(fn() => null);
    }
    // esign
    public function slideOverEsignAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('slideOverEsign')
            ->label('E- SIGN')
            ->icon('heroicon-m-pencil')
            ->disabled(!!$this->leaves ? false : true)
            ->color(function () {

                if (!!$this->leaves?->e_sign) {
                    return Color::Green;
                } else {
                    return Color::Red;
                }
            })
            ->size('sm')
            ->form([
                FileUpload::make('e_sign')->label(new HtmlString("UPLOAD ELECTRONIC SIGNATURE<span class='text-red-500'>(required)</span>"))
                    ->directory('leave/e_sig')->image()->required()->default($this->leaves?->e_sign),
            ])
            ->slideOver()

            ->modalCancelActionLabel('Close')
            ->action(function ($data) {
                \App\Models\LeaveEmployee::where('id_number', Auth::user()->id_number)->update([
                    'e_sign' => $data['e_sign']
                ]);
                Notification::make()
                    ->title('Updated successfully')
                    ->success()
                    ->send();
            });
    }
    // leave card
    public function slideOverLeaveCardAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('slideOverLeaveCard')
            ->label('Leave Card')
            ->icon('heroicon-m-clipboard')
            ->color(Color::Amber)
            ->size('sm')
            ->form([
                ViewField::make('rating')
                    ->view('livewire.leave.personnel.leave-card')
                    ->viewData([
                        'leaveData' => $this->leaveData,
                    ])
            ])
            ->modalWidth(MaxWidth::Full)
            ->slideOver()
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Close')
        ;
    }

    // DTR FUNCTION
    public function slideOverDtrAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('slideOverDtr')
            ->label('DTR')
            ->icon('heroicon-m-calendar-days')
            ->color(Color::Rose)
            ->size('sm')
            ->form(function(){

                return [
                ViewField::make('rating')
                    ->view('livewire.leave.asset.dtr_print_employee')
                    ->viewData([
                        'dtrData' => $this->dtrData,
                    ])
                    ];
            })
            ->modalWidth(MaxWidth::Full)
            ->slideOver()
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Close')
            ;
    }

    // DISABLED ALL WEEKENDS
    #[Computed]
    public function disabledWeekEnds(): array
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

    #[Computed]
    public function minDate(): Carbon
    {

        return Carbon::parse($this->minDates);
    }


    // TABLE
    public function table(Table $table): Table
    {
        // QUERY FORCE LEAVE
        $fl = \App\Models\LeaveEmployeeRequest::query()
            ->where('type_of_leave', \App\Enums\TypeOfLeaveEnum::FORCE_LEAVE->value)
            ->where('id_number', Auth::user()->id_number)
            ->where('status', \App\Enums\LeaveStatusEnum::APPROVED->value)
            ->where('location', 'Records')
            ->whereYear('created_at', Carbon::now())
            ->get();
            // AVAILABLE FORCE LEAVE
            $availableFd = 5 - $fl->sum('days');

            return $table
            ->heading('Leave Request')
            ->headerActions([
                // forms => Leave Request Trait
                CreateAction::make('Request Leave')
                   ->disabled(fn() =>Carbon::now()->format('F Y') !== Carbon::parse($this->leaves?->current_month)->format('F Y') || !$this->leaves?->e_sign)
                    ->label('Request Leave')
                    ->icon('heroicon-o-plus')
                    ->slideOver()
                    ->form(function () use ($availableFd) {

                        return $this->leaveRequestFormStore($availableFd);
                    })
                    ->createAnother(false)
                    ->modalSubmitAction(function (StaticAction $action, $livewire) {
                        $action->disabled(fn(): bool => $this->submitActionButton);
                    })
                    // ->disabled($this->leaves?->e_sign ? false : true)
                    ->action(function ($data) {
                        if (isset($data['other_leave']) && Str::upper($data['other_leave']) == 'CTO')
                        {
                            $countCto = \App\Models\LeaveEmployeeRequest::query()
                                                    ->where('others','CTO')
                                                    ->where('id_number',Auth::user()->id_number)
                                                    ->where('status', \App\Enums\LeaveStatusEnum::APPROVED->value)
                                                    ->get()
                                                    ->sum('paid_days');

                            if ($countCto == 15)
                            {
                                Notification::make()
                                    ->title('NO REMAINING CTO BALANCE')
                                    ->success()
                                    ->send();
                                return;
                            }else{
                                $var = 15 - $countCto;
                                if($var < 0)
                                {

                                    if(($var - (int)$data['paid_days']) < 0)
                                    {
                                        Notification::make()
                                            ->title("The available CTO this year is $var")
                                            ->success()
                                            ->send();
                                        return;
                                    }
                                }
                            }



                        }

                        $cleanedDates = str_replace(' ', '', $data['date'] );
                        $data['date'] =$cleanedDates;

                        $data['date'] = explode(',', $data['date']);

                        usort($data['date'], function ($a, $b) {
                            return strtotime($a) - strtotime($b);
                        });

                        $filename = $this->generateLeaveExcelFile($data);
                        $data['days'] = count($data['date']);
                        $data['id_number'] = Auth::user()->id_number;
                        $data['date'] = json_encode($data['date']);
                        $data['status'] = \App\Enums\LeaveStatusEnum::PENDING->value;
                        $data['original_file'] = $filename;
                        $data['location'] = 'Head';
                        $data['sl'] = $this->leaves['sl'];
                        $data['vl'] = $this->leaves['vl'];
                        $data['fl'] = $this->leaves['fl'];
                        $data['spl'] = $this->leaves['spl'];
                        $data['cto'] = $this->leaveCto;
                        if ($data['type_of_leave'] == \App\Enums\TypeOfLeaveEnum::OTHERS->value) {
                            $data['others'] = $data['other_leave'];
                        }

                        $leaveId = \App\Models\LeaveEmployeeRequest::create($data);
                        $leaveId->update([

                            'code' => Auth::user()->user_fd_code?->division_short_name . "-" . Str::acronym($data['type_of_leave']) . "-" . Carbon::now()->format('Y') . "-" . $leaveId->id
                        ]);
                        \App\Models\LeaveRequestLogs::create([
                            'activity' => "Request $data[type_of_leave]",
                            'remarks' => "For signature of Unit Head.",
                            'location' => Auth::user()->user_fd_code?->division_name,
                            'id_number' => Auth::user()->id_number,
                            'leave_request_id' => $leaveId->code,

                        ]);
                        Notification::make()
                            ->title('Submitted successfully')
                            ->success()
                            ->send();
                    })

            ])
            ->query(\App\Models\LeaveEmployeeRequest::query()->with(['chiefInfo' => fn($q) => $q->with('leavePointLatest'), 'headInfo' => fn($q) => $q->with('leavePointLatest'), 'rdInfo' => fn($q) => $q->with('leavePointLatest'), 'userInfo', 'workExperience'])->where('id_number', Auth::user()->id_number)->orderByDesc('id'))
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
                // logic => Leave Request Trait
                ActionGroup::make($this->myTabActions($availableFd))->tooltip('Actions')
            ]);
    }
    #[Title('My Leave')]
    public function render()
    {


        $employeeInfo = User::with(['leavePointLatestCto', 'leavePointLatest'])->select('id_number', 'name', 'email', 'profile')->where('name', Auth::user()->name)->first();
        $this->leaves = $employeeInfo->leavePointLatest;
        $this->leaveCto = $employeeInfo?->leavePointLatestCto?->sum('points');


        return view('livewire.leave.my-leave', compact('employeeInfo'));
    }
}
