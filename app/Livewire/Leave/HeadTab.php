<?php

namespace App\Livewire\Leave;

use App\Traits\Leave\LeaveRequestTrait;
use Carbon\Carbon;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Get;
use Livewire\Component;
use App\Models\OfficeCode;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;
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

class HeadTab extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use AttachmentTrait;
    use LeaveRequestTrait;
    public $remarks = [
        'line1' => '',
        'line2' => '',
        'line3' => '',
    ];
    public function table(Table $table): Table
    {
        return $table
            ->query(LeaveEmployeeRequest::query()
                ->with('employeeInfo')
                ->where('head_id', Auth::user()->id_number)
                ->where('location', 'Head')
                ->orderByDesc('created_at'))
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
                    IconColumn::make('head_status')->label('HEAD')->toggleable()  ->boolean(),
                IconColumn::make('chief_status')->label('CAO/SAO')->toggleable()  ->boolean(),
                IconColumn::make('rd_status')->label('RD/ARD')->toggleable()  ->boolean(),

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
                            $data['route'] = $user->user_fd_code?->division_name . " -> Administrative Division";
                            return $data;
                        })
                        ->modalWidth(MaxWidth::ExtraLarge)
                        ->label('Forward')
                        ->icon('heroicon-o-arrow-long-right')
                        ->color(Color::Green)
                        ->form([
                            Textarea::make('remarks'),
                            TextInput::make('route')->disabled()
                        ])
                        ->action(function ($data, $record) {
                            $remarks = !!$data['remarks'] ? $data['remarks'] : "";
                            $record->update([
                                'location' => 'Chief',
                                'head_status'=>1
                            ]);
                            $user = User::with('user_fd_code')->where('id_number', $record->id_number)->first();
                            $name = Auth::user()->name;
                            \App\Models\LeaveRequestLogs::create([
                                'activity' => "$name Approved & Forwarded this document",
                                'remarks' => $remarks,
                                'location' => Auth::user()?->user_fd_code?->division_name . " -> Administrative Division",
                                'id_number' => Auth::user()->id_number,
                                'leave_request_id' => $record->code,
                            ]);

                            Notification::make()
                                ->title('Updated successfully')
                                ->success()
                                ->send();
                            // $record->update([
                            //     'location' => 'Chief'
                            // ]);
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

                                'status' => \App\Enums\LeaveStatusEnum::DISAPPROVED->value,
                                'location'=>"Chief",
                                'head_status'=>0
                            ]);
                            $user = User::with('user_fd_code')->where('id_number', $record->id_number)->first();
                            $name = Auth::user()->name;
                            \App\Models\LeaveRequestLogs::create([
                                'activity' => "$name Disapproved & Forwarded this document",
                                'remarks' => "",
                                'location' =>  Auth::user()?->user_fd_code?->division_name . " -> Administrative Division",
                                'id_number' => Auth::user()->id_number,
                                'leave_request_id' => $record->code,
                            ]);

                        })->hidden(fn($record) => $record->type_of_process == 'WET SIGNATURE' ? false : true),













                    // ############################# E SIGN #############################
                    EditAction::make('Approved')
                        ->label('Approved')
                        ->modalHeading('Approved & Forward')
                        ->icon('heroicon-o-check')
                        ->color(Color::Green)
                        ->mutateRecordDataUsing(function ($data, $record) {
                            $user = User::with('user_fd_code')->where('id_number', $record->id_number)->first();
                            $data['route'] =  Auth::user()?->user_fd_code?->division_name . " -> Administrative Division";
                            return $data;
                        })
                        ->form([
                            Textarea::make('remarks'),
                            TextInput::make('route')->readOnly()



                        ])
                        ->action(function ($data,$record) {
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
                            $user = User::with('user_fd_code')->where('id_number', $record->id_number)->first();
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
                            $oldFile =  "/public/leave/$record[original_file]";
                            $data['old_file'] = $record['original_file'];
                            $data['date'] = json_decode($data['date'], true);
                            // $data['remarks'] = $this->remarks;

                            $filename = $this->updateGenerateLeaveExcelFile($data, 'Approved', 'Head');

                            if (Storage::exists($oldFile)) {

                                Storage::delete($oldFile);
                            }
                            $oldRecord->update([
                                'signed_file'=>$filename,
                                'location' => 'Chief',
                                'status' => \App\Enums\LeaveStatusEnum::PENDING->value,
                                'head_status'=>1
                            ]);


                            Notification::make()
                                ->title('Updated successfully')
                                ->success()
                                ->send();
                            // $record->update([
                            //     'location' => 'Chief'
                            // ]);
                        })
                        ->modalSubmitActionLabel('Approved & Forward')
                        ->hidden(fn($record) => $record->type_of_process == 'WET SIGNATURE' ? true : false),
                        EditAction::make('Disapproved')
                        ->label('Disapproved')
                        ->modalHeading('Disapproved & Forward')
                        ->icon('heroicon-o-x-mark')
                        ->color(Color::Red)
                        ->mutateRecordDataUsing(function ($data, $record) {
                            $user = User::with('user_fd_code')->where('id_number', $record->id_number)->first();
                            $data['route'] = $user->user_fd_code?->division_name . " -> Administrative Division";
                            return $data;
                        })
                        ->form([
                            ViewField::make('your-view-name') // Use a custom view if needed
                                ->view('livewire.leave.asset.textarea'),

                                    TextInput::make('route')->disabled()



                        ])
                        ->modalWidth(MaxWidth::Medium)
                        ->action(function ($record) {


                            $oldRecord = $record;
                            $data = $record->toArray();
                            $employeeName = User::select('id_number', 'name')->where('id_number', $record['id_number'])->first();
                            $oldFile =  "/public/leave/$employeeName->name/$record[original_file]";
                            $data['old_file'] = $record['original_file'];
                            $data['date'] = json_decode($data['date'], true);
                            $data['remarks'] = $this->remarks;

                            $filename = $this->updateGenerateLeaveExcelFile($data, 'Disapproved', 'Head');
                            $user = User::with('user_fd_code')->where('id_number', $oldRecord->id_number)->first();
                            $name = Auth::user()->name;
                            $line1 = $this->remarks['line1'];
                            $line2 = $this->remarks['line2'];
                            $line3 = $this->remarks['line3'];
                            \App\Models\LeaveRequestLogs::query()
                                ->create([
                                'activity' => "$name Disapproved & Forwarded this document",
                                'remarks' => new HtmlString("$line1 $line2 $line3"),
                                'location' =>  Auth::user()?->user_fd_code?->division_name . " -> Administrative Division",
                                'id_number' => Auth::user()->id_number,
                                'leave_request_id' => $record->code,
                            ]);
                            // if (Storage::exists($oldFile)) {

                            //     Storage::delete($oldFile);
                            // }
                            $oldRecord->update([
                                'signed_file' => $filename,
                                'status' => \App\Enums\LeaveStatusEnum::DISAPPROVED->value,
                                'disapproved' => json_encode($this->remarks),
                                'location'=>"Chief",
                                'head_status'=>0
                            ]);
                        })->hidden(fn($record) => $record->type_of_process == 'WET SIGNATURE' ? true : false),
                    Action::make('Request_information')
                        ->label('Request Information')
                        ->icon('heroicon-o-eye')
                        ->form([
                            TextInput::make('due')
                        ])
                        ->url(function ($record) {
                            $slug = str_replace(' ', '-', $record->subject_title);
                            $slug = Str::upper($slug);
                            return route('leave.request.view', ['request_id' => $record?->code, 'title' => $slug]);
                        })
                ])

            ])
        ;
    }

    public function render(): View
    {
        return view('livewire.leave.head-tab');
    }
}
