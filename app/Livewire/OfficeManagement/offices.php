<?php

namespace App\Livewire\OfficeManagement;

use App\Models\User;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Livewire\Component;
use App\Models\OfficeCode;
use Filament\Tables\Table;
use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class offices extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(OfficeCode::query())
            ->headerActions([
                // add new office form
             Action::make('add_new_office')
                ->modalHeading('Update Office')
                ->icon('heroicon-o-plus')
                 ->size(ActionSize::Small)
                ->color(Color::Green)
                ->form([
                    TextInput::make('division_code'),
                    TextInput::make('division_short_name'),
                    TextInput::make('division_name'),
                    TextInput::make('fd_chief')
                        ->datalist([
                            'BWM',
                            'Ford',
                            'Mercedes-Benz',
                            'Porsche',
                            'Toyota',
                            'Tesla',
                            'Volkswagen',
                        ]),
                    TextInput::make('chief_designation')
                        ->datalist([
                            'BWM',
                            'Ford',
                            'Mercedes-Benz',
                            'Porsche',
                            'Toyota',
                            'Tesla',
                            'Volkswagen',
                        ])
                ])
                ->action(function($data){
                    $id = OfficeCode::select('id')->orderByDesc('id')->first();
                    $data['division_id'] = $id ? $id?->id : 1;
                    $data['office_level_id'] = 1;
                    OfficeCode::create($data);

                    Notification::make()
                    ->title('Created successfully')
                    ->success()
                    ->send();
                })
            ])
            ->heading('Office Management')
            ->columns([
                TextColumn::make('division_name')->searchable(),
                TextColumn::make('division_short_name')->searchable(),
                TextColumn::make('division_code')->label('Code')->searchable(),
                TextColumn::make('fd_chief')->label('Office Head'),
                TextColumn::make('chief_designation')->searchable(),
            ])
            ->actions([
                // UPDATE OFFICE INFORMATION
                EditAction::make()
                    ->modalHeading('Update Office')
                    ->color(Color::Green)
                    ->form([
                        TextInput::make('division_code'),
                        TextInput::make('division_short_name'),
                        TextInput::make('division_name'),
                        TextInput::make('fd_chief')
                            ->datalist([
                                'BWM',
                                'Ford',
                                'Mercedes-Benz',
                                'Porsche',
                                'Toyota',
                                'Tesla',
                                'Volkswagen',
                            ]),
                            Select::make('id_number')
                            ->label('Head')
                            ->options(User::get()->pluck('name', 'id_number'))
                            ->required()->rules('required')
                            ->searchable()
                            ->default('93668bf8-07bb-4bba-a795-92a355c598d0'),
                        TextInput::make('chief_designation')
                            ->datalist([
                                'BWM',
                                'Ford',
                                'Mercedes-Benz',
                                'Porsche',
                                'Toyota',
                                'Tesla',
                                'Volkswagen',
                            ])
                    ])
                    ->action(function($data,$record){

                        $record->update($data);
                        Notification::make()
                        ->title('Updated successfully')
                        ->success()
                        ->send();
                    }),
                // DeleteAction::make()
            ]);
    }

    #[Title('Office Management')]
    public function render(): View
    {
        return view('livewire.office-management.offices');
    }
}
