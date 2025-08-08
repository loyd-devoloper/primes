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
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ChiefTab extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use AttachmentTrait;
    use LeaveRequestTrait;
    public $remarks = [
        'line1' => '',
        'line2' => '',
        'line3' => '',
        'line4' => '',
    ];
    public function table(Table $table): Table
    {
        return $table
            ->query(LeaveEmployeeRequest::query()
                ->with('employeeInfo')
                ->where('chief_id', Auth::user()->id_number)
                ->where('location', 'Chief')
                ->orderByDesc('created_at')
            )
            ->columns([
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
                    // ############################# WET SIGNATURE #####################
                    EditAction::make('forward')
                        ->modalHeading('Forward')
                        ->mutateRecordDataUsing(function ($data, $record) {
                            $user = User::with('user_fd_code')->where('id_number', $record->id_number)->first();
                            $data['route'] = Auth::user()?->user_fd_code?->division_name . " -> Office of the $record->rd_type";
                            return $data;
                        })
                        ->modalWidth(MaxWidth::ExtraLarge)
                        ->label('Forward')
                        ->icon('heroicon-o-arrow-long-right')
                        ->color(Color::Green)
                        ->form([
                            Textarea::make('remarks'),
                            TextInput::make('route')->readOnly()
                        ])
                        ->action(function ($data, $record) {
                            $remarks = !!$data['remarks'] ? $data['remarks'] : "";
                            $record->update([
                                'location' => 'Rd',
                                'chief_status' => 1
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
                    // Action::make('Disapprovedwe')
                    //     ->label('Disapproved')
                    //     ->icon('heroicon-o-x-mark')
                    //     ->color(Color::Red)
                    //     ->requiresConfirmation()
                    //     ->modalWidth(MaxWidth::Medium)
                    //     ->action(function ($record) {

                    //         $record->update([

                    //             'status' => \App\Enums\LeaveStatusEnum::DISAPPROVED->value
                    //         ]);
                    //         $user = User::with('user_fd_code')->where('id_number', $record->id_number)->first();
                    //         $name = Auth::user()->name;
                    //         \App\Models\LeaveRequestLogs::create([
                    //             'activity' => "$name Disapproved this document.",
                    //             'remarks' => "",
                    //             'location' => Auth::user()?->user_fd_code?->division_name." -> Office of the $record->rd_type",
                    //             'id_number' => Auth::user()->id_number,
                    //             'leave_request_id' => $record->id,
                    //         ]);
                    //     })->hidden(fn($record) => $record->type_of_process == 'WET SIGNATURE' ? false : true),

                    // ############################# E SIGN #############################
                    EditAction::make('Approved')
                        ->label('Approved')
                        ->modalHeading('Approved & Forward')
                        ->icon('heroicon-o-check')
                        ->color(Color::Green)
                        ->mutateRecordDataUsing(function ($data, $record) {

                            $data['route'] = Auth::user()?->user_fd_code?->division_name." -> Office of the $record->rd_type";
                            return $data;
                        })
                        ->form([
                            Textarea::make('remarks'),
                            TextInput::make('route')->readOnly()
                        ])
                        ->action(function ($data, $record) {
                            $my_esign = Auth::user()->leavePointLatest?->e_sign;
                            if($my_esign == null)
                            {
                                Notification::make()
                                    ->title('Kindly upload your electronic signature.')
                                    ->warning()
                                    ->persistent()
                                    ->color('warning')

                                    ->send();
                                return;
                            }
                            $remarks = !!$data['remarks'] ? $data['remarks'] : "";
                            $name = Auth::user()->name;
                            \App\Models\LeaveRequestLogs::create([
                                'activity' => "$name Approved & Forwarded this document",
                                'remarks' => $remarks,
                                'location' => $data['route'],
                                'id_number' => Auth::user()->id_number,
                                'leave_request_id' => $record->code,
                            ]);
                            $oldRecord = $record;
                            $data = $record->toArray();
                            $employeeName = User::select('id_number', 'name')->where('id_number', $record['id_number'])->first();
                            $oldFile =  "/public/leave/$employeeName->name/$record[signed_file]";
                            $data['old_file'] = $record['signed_file'];
                            $data['date'] = json_decode($data['date'], true);
                            // $data['remarks'] = $this->remarks;

                            $filename = $this->updateGenerateLeaveExcelFile($data, 'Approved', 'Chief');

                            if (Storage::exists($oldFile)) {

                                Storage::delete($oldFile);
                            }



                            $oldRecord->update([
                                'signed_file' => $filename,
                                'location' => 'Rd',
                                'chief_status' => 1
                            ]);


                            Notification::make()
                                ->title('Updated successfully')
                                ->success()
                                ->send();
                            // $record->update([
                            //     'location' => 'Chief'
                            // ]);
                        })
                        ->modalWidth(MaxWidth::Large)
                        ->modalSubmitActionLabel('Approved & Forward')
                        ->hidden(fn($record) => $record->type_of_process == 'WET SIGNATURE' ? true : false),
                    // Action::make('Disapproved')
                    //     ->icon('heroicon-o-x-mark')
                    //     ->color(Color::Red)
                    //     ->modalWidth(MaxWidth::Medium)
                    //     ->action(function($record){
                    //         $oldRecord = $record;
                    //         $data = $record->toArray();
                    //         $oldFile =  "/public/leave/$record[original_file]";
                    //         $data['old_file'] = $record['original_file'];
                    //         $data['date'] = json_decode($data['date'],true);
                    //         $data['remarks'] = $this->remarks;

                    //         $filename = $this->updateGenerateLeaveExcelFile($data,'Disapproved','Chief');

                    //         if (Storage::exists($oldFile)) {

                    //             Storage::delete($oldFile);

                    //         }
                    //         $oldRecord->update([
                    //             'original_file'=>$filename
                    //         ]);

                    //     }),
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

    public function render(): View
    {
        return view('livewire.leave.chief-tab');
    }
}
