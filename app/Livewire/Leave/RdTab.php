<?php

namespace App\Livewire\Leave;

use App\Traits\Leave\LeaveRequestTrait;
use Carbon\Carbon;
use App\Models\User;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use App\Models\LeaveEmployeeRequest;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use App\Traits\Leave\AttachmentTrait;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class RdTab extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use AttachmentTrait;
    use LeaveRequestTrait;

    public array $remarks = [
        'line1' => '',
        'line2' => '',
        'line3' => '',
        'line4' => '',
    ];

    public function table(Table $table): Table
    {

        return $table
            ->query(LeaveEmployeeRequest::query()
                ->with(['employeeInfo' => function ($q) {
                    $q->with('leavePointLatestCto', function ($query) {
                        $query->where('points', '>', 0);
                    });
                }, 'leavePointLatest'])
                ->where('rd_id', Auth::user()->id_number)->where('location', 'Rd')
                ->where('rd_type', Auth::user()->user_fd_code?->chief_designation)
                ->orderByDesc('created_at')
            )
            ->columns([
                TextColumn::make('subject_title')->searchable(),
                TextColumn::make('employeeInfo.name')->label('Employee Name')->searchable(),
                TextColumn::make('subject_title')->searchable(),
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
                TextColumn::make('type_of_process'),
                TextColumn::make('location')->toggleable(),
                IconColumn::make('head_status')->label('HEAD')->toggleable()->boolean(),
                IconColumn::make('chief_status')->label('CAO/SAO')->toggleable()->boolean(),
                IconColumn::make('rd_status')->label('RD/ARD')->toggleable()->boolean(),

                TextColumn::make('status')->color(fn($state) => \App\Enums\LeaveStatusEnum::tryFrom($state)?->getColor())
                    ->badge(),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make('forward_and_cancel')
                        ->modalHeading('Forward & Cancel')
                        ->mutateRecordDataUsing(function ($data, $record) {
                            $user = User::with('user_fd_code')->where('id_number', $record->id_number)->first();
                            $data['route'] = Auth::user()?->user_fd_code?->division_name . " -> Records Section";
                            return $data;
                        })
                        ->modalWidth(MaxWidth::ExtraLarge)
                        ->label('Forward & Cancel')
                        ->icon('heroicon-o-arrow-long-right')
                        ->color(Color::Green)
                        ->form([
                            Textarea::make('remarks')->default(""),
                            TextInput::make('route')->readOnly()
                        ])
                        ->action(function ($data, $record) {

                            $remarks = !!$data['remarks'] ? $data['remarks'] : "";
                            $record->update([
                                'location' => 'Records',
                                'status' => \App\Enums\LeaveStatusEnum::CANCELLED->value,
                                'rd_status' => 1
                            ]);

                            $name = Auth::user()->name;
                            \App\Models\LeaveRequestLogs::create([
                                'activity' => "$name Approved & Forwarded this document",
                                'remarks' => $remarks,
                                'location' => $data['route'],
                                'id_number' => Auth::user()->id_number,
                                'leave_request_id' => $record->code,
                            ]);


                            Notification::make()
                                ->title('Updated successfully')
                                ->success()
                                ->send();
                        })
                        ->modalSubmitActionLabel('Forward')
                        ->hidden(fn($record) => $record->type_of_process == 'WET SIGNATURE' ? false : true),
                    // ############################# WET SIGNATURE #####################
                    EditAction::make('forward')
                        ->modalHeading('Forward')
                        ->mutateRecordDataUsing(function ($data, $record) {
                            $user = User::with('user_fd_code')->where('id_number', $record->id_number)->first();
                            $data['route'] = Auth::user()?->user_fd_code?->division_name . " -> Records Section";
                            return $data;
                        })
                        ->modalWidth(MaxWidth::ExtraLarge)
                        ->label('Forward')
                        ->icon('heroicon-o-arrow-long-right')
                        ->color(Color::Green)
                        ->form([
                            Textarea::make('remarks')->default(""),
                            TextInput::make('route')->readOnly()
                        ])
                        ->action(function ($data, $record) {

                            $remarks = !!$data['remarks'] ? $data['remarks'] : "";
                            $record->update([
                                'location' => 'Records',
                                'status' => $record->head_status == 1 && $record->chief_status == 1 ? \App\Enums\LeaveStatusEnum::APPROVED->value : \App\Enums\LeaveStatusEnum::DISAPPROVED->value,
                                'rd_status' => 1
                            ]);

                            $name = Auth::user()->name;
                            \App\Models\LeaveRequestLogs::create([
                                'activity' => "$name Approved & Forwarded this document",
                                'remarks' => $remarks,
                                'location' => $data['route'],
                                'id_number' => Auth::user()->id_number,
                                'leave_request_id' => $record->code,
                            ]);
                            if ($record?->head_status == '1' && $record->chief_status == '1') {
                                if ($record->type_of_leave == \App\Enums\TypeOfLeaveEnum::SICK_LEAVE->value) {
                                    $record->leavePointLatest->update([
                                        'sl' => (float)$record->leavePointLatest?->sl - (float)$record->paid_days
                                    ]);
                                    $now = Carbon::now();
                                    \App\Models\Leave\LeaveCard::query()
                                        ->updateOrCreate([
                                            'id_number' => $record->id_number,
                                            'request_id' => $record->code,

                                        ], [
                                            'start_date' => $now,
                                            'days' => str_pad($record?->paid_days, 2, '0', STR_PAD_LEFT),
                                            'hours' => "00",
                                            'mins' => "00",
                                            'w_pay' => $record->paid_days,
                                            'type' => "SL",
                                            'remarks' => $this->convertDate(json_decode($record?->date)),
                                            'vl_balance' => $record->leavePointLatest?->vl,
                                            'sl_balance' => $record->leavePointLatest?->sl,
                                            'id_number' => $record->id_number
                                        ]);
                                } else if ($record->type_of_leave == \App\Enums\TypeOfLeaveEnum::FORCE_LEAVE->value) {
                                    $record->leavePointLatest->update([
                                        'vl' => (float)$record->leavePointLatest?->vl - (float)$record->paid_days,
                                        'fl' => (float)$record->leavePointLatest?->fl - (float)$record->paid_days,
                                    ]);
                                    $now = Carbon::now();

                                    \App\Models\Leave\LeaveCard::query()
                                        ->updateOrCreate([
                                            'id_number' => $record->id_number,
                                            'request_id' => $record->code,

                                        ], [
                                            'start_date' => $now,
                                            'days' => str_pad($record?->paid_days, 2, '0', STR_PAD_LEFT),
                                            'hours' => "00",
                                            'mins' => "00",
                                            'w_pay' => $record->paid_days,
                                            'type' => "FL",
                                            'remarks' => $this->convertDate(json_decode($record?->date)),
                                            'vl_balance' => $record->leavePointLatest?->vl,
                                            'sl_balance' => $record->leavePointLatest?->sl,
                                            'id_number' => $record->id_number
                                        ]);
                                } else if ($record->type_of_leave == \App\Enums\TypeOfLeaveEnum::VACATION_LEAVE->value) {
                                    $record->leavePointLatest->update([
                                        'vl' => (float)$record->leavePointLatest?->vl - (float)$record->paid_days
                                    ]);
                                    $now = Carbon::now();

                                    \App\Models\Leave\LeaveCard::query()
                                        ->updateOrCreate([
                                            'id_number' => $record->id_number,
                                            'request_id' => $record->code,

                                        ], [
                                            'start_date' => $now,
                                            'days' => str_pad($record?->paid_days, 2, '0', STR_PAD_LEFT),
                                            'hours' => "00",
                                            'mins' => "00",
                                            'w_pay' => $record->paid_days,
                                            'type' => "VL",
                                            'remarks' => $this->convertDate(json_decode($record?->date)),
                                            'vl_balance' => $record->leavePointLatest?->vl,
                                            'sl_balance' => $record->leavePointLatest?->sl,
                                            'id_number' => $record->id_number
                                        ]);
                                } else if ($record->type_of_leave == \App\Enums\TypeOfLeaveEnum::SPECIAL_PRIVILEGE_LEAVE->value) {
                                    $record->leavePointLatest->update([
                                        'spl' => (float)$record->leavePointLatest?->spl - (float)$record->paid_days
                                    ]);
                                    $now = Carbon::now();

                                    \App\Models\Leave\LeaveCard::query()
                                        ->updateOrCreate([
                                            'id_number' => $record->id_number,
                                            'request_id' => $record->code,

                                        ], [
                                            'start_date' => $now,
                                            'days' => str_pad($record?->paid_days, 2, '0', STR_PAD_LEFT),
                                            'hours' => "00",
                                            'mins' => "00",
                                            'type' => "SPL",
                                            'remarks' => $this->convertDate(json_decode($record?->date)),
                                            'vl_balance' => $record->leavePointLatest?->vl,
                                            'sl_balance' => $record->leavePointLatest?->sl,
                                            'id_number' => $record->id_number
                                        ]);
                                } else if ($record->type_of_leave == \App\Enums\TypeOfLeaveEnum::OTHERS->value && $record->others == 'CTO') {

                                    $i = (int)$record->paid_days;
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
                                    $now = Carbon::now();
                                    \App\Models\Leave\LeaveCard::query()
                                        ->updateOrCreate([
                                            'id_number' => $record->id_number,
                                            'request_id' => $record->code,

                                        ], [
                                            'start_date' => $now,
                                            'w_pay' => $record->paid_days,
                                            'days' => str_pad($record?->paid_days, 2, '0', STR_PAD_LEFT),
                                            'hours' => "00",
                                            'mins' => "00",
                                            'type' => "CTO",
                                            'remarks' => $this->convertDate(json_decode($record?->date)),
                                            'cto_balance' => $record->employeeInfo?->leavePointLatestCto->sum('points'),
                                            'id_number' => $record->id_number
                                        ]);
                                }
                            }


                            Notification::make()
                                ->title('Updated successfully')
                                ->success()
                                ->send();
                        })
                        ->modalSubmitActionLabel('Forward')
                        ->hidden(fn($record) => $record->type_of_process == 'WET SIGNATURE' ? false : true),
                    Action::make('Disapprovedwe')
                        ->label('Disapproved')
                        ->icon('heroicon-o-x-mark')
                        ->color(Color::Red)
                        ->requiresConfirmation()
                        ->modalWidth(MaxWidth::Medium)
                        ->action(function ($record) {
                            $record->update([
                                'location' => 'Records',
                                'status' => \App\Enums\LeaveStatusEnum::DISAPPROVED->value,
                                'rd_status' => 0
                            ]);

                            $name = Auth::user()->name;
                            \App\Models\LeaveRequestLogs::create([
                                'activity' => "$name Disapproved & Forwarded this document",
                                'remarks' => "",
                                'location' => Auth::user()?->user_fd_code?->division_name . " -> Records Section",
                                'id_number' => Auth::user()->id_number,
                                'leave_request_id' => $record->code,
                            ]);
                        })->hidden(fn($record) => $record->type_of_process == 'WET SIGNATURE' ? false : true),

                    // ############################# E SIGN #############################
                    EditAction::make('Approved')
                        ->label('Approved')
                        ->icon('heroicon-o-check')
                        ->color(Color::Green)
                        ->mutateRecordDataUsing(function ($data, $record) {
                            $user = User::with('user_fd_code')->where('id_number', $record->id_number)->first();
                            $data['route'] = Auth::user()?->user_fd_code?->division_name . " -> Records Section";
                            return $data;
                        })
                        ->form([
                            Textarea::make('remark')->default(""),
                            TextInput::make('route')->readOnly()
                        ])
                        ->action(function ($data, $record) {

//                            foreach ($data as $key => $value)
//                            {
//                                if ($i > 0) {
//
//                                    if ((float)$data[$key] > 0) {
//
//
//                                        while ($i > 0 && (float)$data[$key] > 0) {
//
//
//                                            if((float)$data[$key] > 0)
//                                            {
//
//                                                $data[$key] = $data[$key] - 1;
//
//                                            }
//                                            $i--;
//
//                                        }
//                                    }
//
//
//                                }
//                            }


                            $my_esign = Auth::user()->leavePointLatest?->e_sign;
                            if ($my_esign == null) {
                                Notification::make()
                                    ->title('Kindly upload your electronic signature.')
                                    ->warning()
                                    ->persistent()
                                    ->color('warning')
                                    ->send();
                                return;
                            }
                            $oldRecord = $record;
                            $newData = $record->toArray();
                            $employeeName = User::select('id_number', 'name')->where('id_number', $record['id_number'])->first();
                            $oldFile = "/public/leave/$employeeName->name/$record[signed_file]";

                            $newData['old_file'] = $record['signed_file'];
                            $newData['date'] = json_decode($newData['date'], true);
                            $newData['newRemarks'] = $this->remarks;

                            $filename = $this->updateGenerateLeaveExcelFile($newData, 'Approved', 'Rd');

                            if (Storage::exists($oldFile)) {

                                Storage::delete($oldFile);
                            }
                            $oldRecord->update([
                                'signed_file' => $filename,
                                'location' => 'Records',
                                'status' => $record->head_status == 1 && $record->chief_status == 1 ? \App\Enums\LeaveStatusEnum::APPROVED->value : \App\Enums\LeaveStatusEnum::DISAPPROVED->value,
                                'rd_status' => 1
                            ]);
                            if ($record?->head_status == '1' && $record->chief_status == '1') {
                                if ($record->type_of_leave == \App\Enums\TypeOfLeaveEnum::SICK_LEAVE->value) {
                                    $record->leavePointLatest->update([
                                        'sl' => (float)$record->leavePointLatest?->sl - (float)$record->paid_days
                                    ]);
                                    $now = Carbon::now();

                                    \App\Models\Leave\LeaveCard::query()
                                        ->updateOrCreate([
                                            'id_number' => $record->id_number,
                                            'request_id' => $record->code,

                                        ], [
                                            'start_date' => $now,
                                            'days' => str_pad($record?->paid_days, 2, '0', STR_PAD_LEFT),
                                            'hours' => "00",
                                            'mins' => "00",
                                            'w_pay' => $record->paid_days,
                                            'type' => "SL",
                                            'remarks' => $this->convertDate(json_decode($record?->date)),
                                            'vl_balance' => $record->leavePointLatest?->vl,
                                            'sl_balance' => $record->leavePointLatest?->sl,
                                            'id_number' => $record->id_number
                                        ]);
                                } else if ($record->type_of_leave == \App\Enums\TypeOfLeaveEnum::FORCE_LEAVE->value) {
                                    $record->leavePointLatest->update([
                                        'vl' => (float)$record->leavePointLatest?->vl - (float)$record->paid_days,
                                        'fl' => (float)$record->leavePointLatest?->fl - (float)$record->paid_days,
                                    ]);
                                    $now = Carbon::now();

                                    \App\Models\Leave\LeaveCard::query()
                                        ->updateOrCreate([
                                            'id_number' => $record->id_number,
                                            'request_id' => $record->code,

                                        ], [
                                            'start_date' => $now,
                                            'days' => str_pad($record?->paid_days, 2, '0', STR_PAD_LEFT),
                                            'hours' => "00",
                                            'mins' => "00",
                                            'w_pay' => $record->paid_days,
                                            'type' => "FL",
                                            'remarks' => $this->convertDate(json_decode($record?->date)),
                                            'vl_balance' => $record->leavePointLatest?->vl,
                                            'sl_balance' => $record->leavePointLatest?->sl,
                                            'id_number' => $record->id_number
                                        ]);
                                } else if ($record->type_of_leave == \App\Enums\TypeOfLeaveEnum::VACATION_LEAVE->value) {
                                    $record->leavePointLatest->update([
                                        'vl' => (float)$record->leavePointLatest?->vl - (float)$record->paid_days
                                    ]);
                                    $now = Carbon::now();

                                    \App\Models\Leave\LeaveCard::query()
                                        ->updateOrCreate([
                                            'id_number' => $record->id_number,
                                            'request_id' => $record->code,

                                        ], [
                                            'start_date' => $now,
                                            'days' => str_pad($record?->paid_days, 2, '0', STR_PAD_LEFT),
                                            'hours' => "00",
                                            'mins' => "00",
                                            'w_pay' => $record->paid_days,
                                            'type' => "VL",
                                            'remarks' => $this->convertDate(json_decode($record?->date)),
                                            'vl_balance' => $record->leavePointLatest?->vl,
                                            'sl_balance' => $record->leavePointLatest?->sl,
                                            'id_number' => $record->id_number
                                        ]);
                                } else if ($record->type_of_leave == \App\Enums\TypeOfLeaveEnum::SPECIAL_PRIVILEGE_LEAVE->value) {
                                    $record->leavePointLatest->update([
                                        'spl' => (float)$record->leavePointLatest?->spl - (float)$record->paid_days
                                    ]);
                                    $now = Carbon::now();

                                    \App\Models\Leave\LeaveCard::query()
                                        ->updateOrCreate([
                                            'id_number' => $record->id_number,
                                            'request_id' => $record->code,

                                        ], [
                                            'start_date' => $now,
                                            'days' => str_pad($record?->paid_days, 2, '0', STR_PAD_LEFT),
                                            'hours' => "00",
                                            'mins' => "00",
                                            'type' => "SPL",
                                            'remarks' => $this->convertDate(json_decode($record?->date)),
                                            'vl_balance' => $record->leavePointLatest?->vl,
                                            'sl_balance' => $record->leavePointLatest?->sl,
                                            'id_number' => $record->id_number
                                        ]);
                                } else if ($record->type_of_leave == \App\Enums\TypeOfLeaveEnum::OTHERS->value && Str::upper($record->others) == 'CTO') {
                                    $i = (int)$record->paid_days;
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
                                    $now = Carbon::now();
                                    \App\Models\Leave\LeaveCard::query()
                                        ->updateOrCreate([
                                            'id_number' => $record->id_number,
                                            'request_id' => $record->code,

                                        ], [
                                            'start_date' => $now,
                                            'w_pay' => $record->paid_days,
                                            'days' => str_pad($record?->paid_days, 2, '0', STR_PAD_LEFT),
                                            'hours' => "00",
                                            'mins' => "00",
                                            'type' => "CTO",
                                            'remarks' => $this->convertDate(json_decode($record?->date)),
                                            'cto_balance' => $record->employeeInfo?->leavePointLatestCto->sum('points'),
                                            'id_number' => $record->id_number
                                        ]);
                                }
                            }
                            $remark = !!$data['remark'] ? $data['remark'] : "";
                            $name = Auth::user()->name;
                            \App\Models\LeaveRequestLogs::create([
                                'activity' => "$name Approved & Forwarded this document",
                                'remarks' => $remark,
                                'location' => $data['route'],
                                'id_number' => Auth::user()->id_number,
                                'leave_request_id' => $oldRecord->code,
                            ]);
                            Notification::make()
                                ->title('Updated successfully')
                                ->success()
                                ->send();

                        })
                        ->hidden(fn($record) => $record->type_of_process == 'WET SIGNATURE' ? true : false),
                    Action::make('Disapproved')
                        ->icon('heroicon-o-x-mark')
                        ->color(Color::Red)
                        ->modalWidth(MaxWidth::Medium)
                        ->action(function ($record) {
                            $oldRecord = $record;
                            $data = $record->toArray();
                            $employeeName = User::select('id_number', 'name')->where('id_number', $record['id_number'])->first();
                            $oldFile = "/public/leave/$employeeName->name/$record[original_file]";
                            $data['old_file'] = $record['original_file'];
                            $data['date'] = json_decode($data['date'], true);
                            $data['remarks'] = $this->remarks;

                            $filename = $this->updateGenerateLeaveExcelFile($data, 'Disapproved', 'Rd');

                            if (Storage::exists($oldFile)) {

                                Storage::delete($oldFile);
                            }
                            $oldRecord->update([
                                'original_file' => $filename,
                                'rd_status' => 0,
                                'location' => 'Records',
                                'status' => \App\Enums\LeaveStatusEnum::DISAPPROVED->value
                            ]);

                            $name = Auth::user()->name;
                            \App\Models\LeaveRequestLogs::create([
                                'activity' => "$name Disapproved & Forwarded this document",
                                'remarks' => "",
                                'location' => Auth::user()?->user_fd_code?->division_name . " -> Records Section",
                                'id_number' => Auth::user()->id_number,
                                'leave_request_id' => $record->code,
                            ]);
                        })
                        ->hidden(fn($record) => $record->type_of_process == 'WET SIGNATURE' ? true : false),
                    Action::make('Request_information')
                        ->label('Request Information')
                        ->icon('heroicon-o-eye')
                        ->url(function ($record) {
                            $slug = str_replace(' ', '-', $record->subject_title);
                            $slug = Str::upper($slug);
                            return route('leave.request.view', ['request_id' => $record?->code, 'title' => $slug]);
                        })
                ])

            ]);
    }

    public function convertDate($dates): string
    {

        $formattedDates = [];

        foreach ($dates as $date) {

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

        // Join the formatted strings with " And "

        // Join the formatted strings with " And "
        $output = implode(' - ', $formattedStrings);
        return $output;
    }

    public function render(): View
    {
//        $data = [
//            'cto1' => 2,
//            'cto2' => 6,
//            'cto3' => 2
//        ];
//        $i = 9;
//        $x = [];
//
//        dd($data,$i,$x);
        return view('livewire.leave.rd-tab');
    }
}
