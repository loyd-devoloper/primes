<?php

namespace App\Livewire\leave;

use Carbon\Carbon;
use App\Models\User;
use Filament\Forms\Components\Textarea;
use Filament\Tables;
use App\Models\Users;
use Filament\Forms\Get;
use Filament\Tables\Actions\DeleteAction;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\KeyValue;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;

class BulkCto extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    public function logsTable($old, $new)
    {
        return "<div class='flex items-center gap-5'>
        <div class='grid max-w-max'>
            <h1 class='border-2 border-black text-center px-10 py-2  rounded-t-md   font-bold'>Before</h1>
            <div class='border-x-2 border-b-2 border-black  px-10 py-2  '>
                 $old points
            </div>
        </div>
        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' class='size-6  text-black dark:text-white'>
            <path fill-rule='evenodd'
                d='M16.72 7.72a.75.75 0 0 1 1.06 0l3.75 3.75a.75.75 0 0 1 0 1.06l-3.75 3.75a.75.75 0 1 1-1.06-1.06l2.47-2.47H3a.75.75 0 0 1 0-1.5h16.19l-2.47-2.47a.75.75 0 0 1 0-1.06Z'
                clip-rule='evenodd' />
        </svg>

        <div class='grid max-w-max'>
            <h1 class='border-2 border-black text-center px-10 py-2  rounded-t-md   font-bold'>After</h1>
            <div class='border-x-2 border-b-2 border-black  px-10 py-2  '>
                $new points
            </div>
        </div>
    </div>";
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\Leave\LeaveBulkCto::query()->with('employeeInfo')->orderByDesc('id'))
            ->headerActions([
                Action::make('bulk')
                    ->label('Create Bulk CTO')
                    ->icon('heroicon-o-plus')
                    ->form([
                        Select::make('employees')
                            ->multiple()
                            ->options(User::whereHas('workExperienceCurrent', function ($query) {
                                $query->where('status_appointment', 'Permanent');
                            })->get() ->pluck('name', 'id_number'))
                            ->native(false),
                        TextInput::make('subject')->required(),
                        TextInput::make('points')->numeric()->required()->step('any'),
                        DatePicker::make('effective_date')->label('Effectivity Date')->required(),
                        Textarea::make('remarks')->placeholder('Dec 20,21,21 2024')->required(),
                        FileUpload::make('attachment')
                            ->directory(Carbon::now()->format('Y').'/leave/bulkcto')
                            ->acceptedFileTypes(['application/pdf'])->required()
                    ])
                    ->action(function ($data) {
                        $expired = Carbon::parse($data['effective_date'])->addYear()->format('Y-m-d');
                        $effective_date = Carbon::parse($data['effective_date'])->format('Y-m-d');
                        $data['expired_date'] = $expired;
                        $data['effective_date'] = $effective_date;

                        $data['status'] = \App\Enums\CtoStatusEnum::ACTIVE->value;
                        $name = Auth::user()->name;
                        $now = Carbon::now();

                        $transaction = \App\Models\Leave\LeaveBulkCto::query()
                        ->create([
                            'subject' => $data['subject'],
                            'points' => $data['points'],
                            'effective_date' => $data['effective_date'],
                            'expired_date' => $data['expired_date'],
                            'employees' => json_encode($data['employees']),
                            'attachment' => $data['attachment'],
                            'id_number' => Auth::user()->id_number,
                        ]);

                        foreach ($data['employees'] as $employee) {
                            $userCto = \App\Models\Leave\LeaveCto::query()
                                ->where('id_number', $employee)
                                ->where('points','>',0)
                                ->get();


                            $old = (float)$userCto->sum('points');
                            $new = (float) $userCto->sum('points') + (float)$data['points'];
                            // add to leave card Cto
                            \App\Models\Leave\LeaveCard::query()
                                ->updateOrCreate([
                                    'id_number' => $employee,
                                    'request_id' => $transaction->id,
                                ],[
                                    'particulars'=>$data['subject'],
                                    'start_date' => $now,

                                    'type' => "CTO",
                                    'remarks' => $data['remarks'],
                                    'cto_balance' =>$new,
                                    'id_number' =>  $employee,
                                    'vl_earn'=>$data['points']
                                ]);
                            $data['id_number'] = $employee;
                            $data['bulk_id'] = $transaction->id;
                            \App\Models\Leave\LeaveCto::query()->create($data);
                            \App\Models\Leave\LeaveEmployeeActivityLog::query()
                                ->create([
                                'activity' => "$name Updated CTO Points",
                                'remarks' =>  $this->logsTable($old, $new),
                                'location' => Auth::user()->user_fd_code?->division_name,
                                'employee_leave_id' => $employee,
                                'id_number' => Auth::user()->id_number,
                                'attachment' => $data['attachment']
                                ]);
                        }

                        Notification::make()
                            ->title('Created successfully')
                            ->success()
                            ->send();
                    })
            ])
            ->columns([
                TextColumn::make('subject')->wrap(),
                TextColumn::make('points'),
                TextColumn::make('effective_date')->label('Effectivity Date'),
                TextColumn::make('expired_date'),
                TextColumn::make('employeeInfo.name')->label('Created By'),
                TextColumn::make('created_at')->formatStateUsing(fn($state) => Carbon::parse($state)->format('F d, Y h:i:s A')),
            ])

            ->actions([
                ViewAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
                        $arr = [];
                        foreach (json_decode($data['employees']) as $employee) {
                            $user = User::select('id_number', 'name', 'fd_code')->with('user_fd_code')->where('id_number', $employee)->first();
                            $arr[$user->name] = $user->user_fd_code?->division_name;
                        }
                        $data['meta'] = $arr;

                        return $data;
                    })
                    ->icon('heroicon-m-information-circle')
                    ->label('Information')
                    ->form(function ($record) {
                        $link = $record->attachment;
                        $arr = [
                            Grid::make([
                                'default'=>7,
                                'sm'=>7
                            ])
                            ->schema([
                                PdfViewerField::make('file')
                                ->label(false)
                                ->minHeight('80svh')
                                ->fileUrl(Storage::url($link))
                                ->columnSpan(4),
                            KeyValue::make('meta')
                                ->label(false)
                                ->keyLabel('Property name')
                                ->valueLabel('Section/Unit/Division')
                                 ->columnSpan(3)
                            ])
                        ];

                        return $arr;
                    })
                    ->modalWidth(MaxWidth::ScreenTwoExtraLarge),
                DeleteAction::make('delete')
                        ->label('Delete')
                        ->action(function ($record) {
                            \App\Models\Leave\LeaveCard::query()
                                ->where('request_id', $record->id)
                                ->delete();
                            \App\Models\Leave\LeaveCto::query()->where('bulk_id', $record->id)->delete();
                            $record->delete();
                            Notification::make()
                                ->success()
                                ->title('Deleted successfully')
                                ->send();
                        })
            ])
        ;
    }

    public function render(): View
    {
        return view('livewire.leave.bulk-cto');
    }
}
