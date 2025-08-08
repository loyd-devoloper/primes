<?php

namespace App\Livewire\UserManagement;

use Filament\Forms\Components\Select;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Permission extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(\Spatie\Permission\Models\Permission::query())
            ->heading('Permission')
            ->headerActions([
                // create permission
                Action::make('add_permission')
                    ->modalHeading('Create Permission')
                    ->icon('heroicon-o-plus')
                    ->form([
                        Select::make('name')
                        ->options(\App\Enums\UserManagement\PermissionEnum::class)
                        ->required()
                        ->rules('required|unique:permissions,name'),
                    ])
                    ->action(function ($data) {
                        \Spatie\Permission\Models\Permission::create($data);
                        Notification::make()
                            ->title('Created successfully')
                            ->success()
                            ->send();
                    })
                    ->modalWidth(MaxWidth::Small)
            ])
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('guard_name'),
            ])
            ->actions([
                // EDIT PERMISSION
                EditAction::make()
                    ->color(Color::Green)
                    ->modalHeading('Edit Permission')
                    ->form([
                        Select::make('name')
                            ->options(\App\Enums\UserManagement\PermissionEnum::class)
                            ->required()
                            ->rules('required'),

                    ])
                    ->modalWidth(MaxWidth::Small)
            ]);
    }
    #[Title("User Management")]
    public function render(): View
    {
        return view('livewire.user-management.permission');
    }
}
