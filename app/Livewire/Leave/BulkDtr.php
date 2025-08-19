<?php

namespace App\Livewire\Leave;


use Carbon\Carbon;

use App\Models\User;

use Livewire\Component;
use Filament\Tables\Table;
use App\Models\Leave\LeaveBulkDtr;
use Filament\Support\Colors\Color;

use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;

use Filament\Forms\Contracts\HasForms;
use App\Models\Leave\LeaveBulkDtrGroup;

use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;

use App\Traits\Leave\PersonnelLeaveTrait;

use Filament\Tables\Actions\DeleteAction;

use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;


class BulkDtr extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;
    use PersonnelLeaveTrait;

    public $file, $selectupdateDtr, $dtrArrView;

    public array $dtrArr = [];
    public $employee = [];
    public string $month = '';
    public $globalMonth;

    public function updating($property, $value): void
    {

        if ($property === 'file') {
            $this->file = !!$value ? $value->getFilename() : '';

            $this->loadDtrNew();
        }
    }



    public function table(Table $table): Table
    {
        $query = LeaveBulkDtrGroup::query()->orderBy('created_at', 'desc');


        return $table
            ->query($query)
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
                                $this->loadDtrNew();
                                $action->cancelParentActions();
                            })
                    ])
                    ->slideOver()
                    ->modalCancelAction(false)
                    ->action(function ($data, $record) {
                        $uuid = LeaveBulkDtrGroup::query()->create([
                            'name'=>$data['batch']
                        ]);
                        foreach ($this->dtrArr as $key => $value) {
                            $user = User::query()->whereJsonContains('dtr_key->'. $key, $key)->first();
                            LeaveBulkDtr::query()->create([
                                'id_number'=>$user ? $user->id_number : null,
                                'dtr' => json_encode($value),
                                'date' => Carbon::parse($this->month)->format('Y-m-d'),
                                'batch' => $data['batch'],
                                'group_id' => $uuid->id,
                                'user_name' => $key
                            ]);
                        }
                        $this->dtrArr = [];
                        Notification::make()
                            ->title('Success!')
                            ->body('The form has been submitted successfully.')
                            ->success()
                            ->send();
                    })
            ])

            ->columns([
                // TextColumn::make('date')->sortable(['created_at']),
                // TextColumn::make('batch'),
                // TextColumn::make('user_name')->searchable(),
                // TextColumn::make('employee.name')->searchable(),
                  TextColumn::make('name')->searchable(),
            ])
            ->actions([
                ViewAction::make('view')->url(fn($record) => route('leave.employees.dtr', ['dtr_group'=>$record?->id])),
                 DeleteAction::make('delete')->action(function($record) {
LeaveBulkDtr::query()->where('group_id',$record->id)->delete();
                    $record->delete();
                      Notification::make()
            ->title('Deleted successfully')
            ->success()
            ->send();
                 })
            ]);
            ;

    }



    public function render(): View
    {


        return view('livewire.leave.bulk_dtr');
    }
}
