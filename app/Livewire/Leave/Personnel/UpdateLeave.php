<?php

namespace App\Livewire\Leave\Personnel;

use Livewire\Component;
use Filament\Tables\Table;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;

class UpdateLeave extends Component implements HasActions, HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithActions;
    use InteractsWithTable;

    public $employee_id = '';
    public $employee_name = '';
    public $currentCtoPoints = '';
    public function mount()
    {
        $ctos = \App\Models\Leave\LeaveCto::where('id_number', $this->employee_id)->get();
        $this->currentCtoPoints = $ctos->sum('points');
    }
    public function slideOverAction()
    {
        return \Filament\Actions\Action::make('slideOver')
            ->label('Activity Logs')
            ->icon('heroicon-m-clock')
            ->color(Color::Gray)
            ->size('sm')
            ->form([
                Select::make('authorId')
                    ->label('Author')
                    ->required(),
            ])
            ->slideOver()
            ->action(fn() => null);
    }
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
            ->query(\App\Models\Leave\LeaveCto::query()->where('id_number', $this->employee_id)->orderByDesc('effective_date'))
            ->columns([
                TextColumn::make('subject')->wrap(),
                TextColumn::make('points'),
                TextColumn::make('status'),
                TextColumn::make('effective_date')->label('Effectivity Date'),
                TextColumn::make('expired_date'),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                        ->icon('heroicon-m-information-circle')
                        ->label('Information')
                        ->form(function ($record) {
                            $link = $record->attachment;
                            $arr = [
                                PdfViewerField::make('file')
                                    ->label(false)
                                    ->minHeight('80svh')
                                    ->fileUrl(Storage::url($link))
                            ];

                            return $arr;
                        })
                        ->modalWidth(MaxWidth::ScreenTwoExtraLarge),
//                    EditAction::make()
//                        ->modalHeading('EDIT CTO')
//                        ->form([
//                            TextInput::make('subject')->required(),
//                            TextInput::make('points')->numeric()->required()->step('any'),
//                            DatePicker::make('effective_date')->label('Effectivity Date')->required(),
//                            Select::make('status')->options(\App\Enums\CtoStatusEnum::class)
//                        ])
//                        ->color(Color::Green)
//                        ->slideOver()
//                        ->action(function ($data, $record) {
//
//                            $expired = Carbon::parse($data['effective_date'])->addYear()->format('Y-m-d');
//                            $effective_date = Carbon::parse($data['effective_date'])->format('Y-m-d');
//                            $data['expired_date'] = $expired;
//                            $data['effective_date'] = $effective_date;
//                            $old = $record->points;
//                            $record->update($data);
//                            if (!!$record->getChanges()) {
//                                $name = Auth::user()->name;
//
//                                $new =  ((float)$this->currentCtoPoints - (float)$old) + (float)$data['points'];
//                                \App\Models\Leave\LeaveEmployeeActivityLog::create([
//                                    'activity' => "$name Updated CTO Points",
//                                    'remarks' =>  $this->logsTable($this->currentCtoPoints, $new),
//                                    'location' => Auth::user()->user_fd_code?->division_name,
//                                    'employee_leave_id' => $this->employee_id,
//                                    'id_number' => Auth::user()->id_number,
//                                ]);
//                            }
//
//                            Notification::make()
//                                ->title('Updated successfully')
//                                ->success()->send();
//                            return redirect()->route('leave.employees.view', ['employee_id' => $this->employee_id, 'employee_name' => $this->employee_name, 'tab' => "UPDATE-LEAVE"]);
//                        })
//                        ->extraAttributes(['class' => 'ctoModal']),
                    DeleteAction::make()
                    ->action(function ($record) {
                        $old = $record->points;
                        $record->delete();

                        $name = Auth::user()->name;

                        $new =  (float)$this->currentCtoPoints - (float)$old;
                        \App\Models\Leave\LeaveEmployeeActivityLog::create([
                            'activity' => "$name Updated CTO Points",
                            'remarks' =>  $this->logsTable($this->currentCtoPoints, $new),
                            'location' => Auth::user()->user_fd_code?->division_name,
                            'employee_leave_id' => $this->employee_id,
                            'id_number' => Auth::user()->id_number,
                        ]);

                        Notification::make()
                            ->title('Deleted successfully')
                            ->success()->send();
                        return redirect()->route('leave.employees.view', ['employee_id' => $this->employee_id, 'employee_name' => $this->employee_name, 'tab' => "UPDATE-LEAVE"]);
                    })->hidden(fn($record) => !!$record->bulk_id ? true : false),
                ])

            ]);
    }
    public function render()
    {
        return view('livewire.leave.personnel.update-leave');
    }
}
