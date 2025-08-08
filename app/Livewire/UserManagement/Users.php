<?php

namespace App\Livewire\UserManagement;

use App\Models\User;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\Grid;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Users extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {

        return $table
            ->query(User::query()->with(['user_fd_code']))
            ->heading('Users')

            ->columns([
                TextColumn::make('name')->label('Full Name')->searchable(),
                TextColumn::make('user_fd_code.division_name')->label('Unit/Division')->searchable(),
                TextColumn::make('status')->searchable(),
                TextColumn::make('permissions.name')
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->badge()
                    ->color(Color::Green)
                    ->expandableLimitedList()
                    ->searchable()

            ])
            ->actions([
                EditAction::make()
                    ->label('Update Permission')
                    ->color(Color::Green)
                    ->slideOver()

                    ->form(function ($record) {

                        $permissionsData = \Spatie\Permission\Models\Permission::get();
                        $arr = [];
                        foreach ($permissionsData as $permission) {


                            $arr[] = Checkbox::make($permission->name)->label($permission->name)->formatStateUsing(fn() => $record->hasPermissionTo($permission->name) ? true : false);
                        }
                        return [Grid::make([
                            'default' => 2
                        ])->schema($arr)];
                    })
                    ->action(function ($data, $record) {
                        foreach ($data as $key => $permission) {
                            if ($permission) {
                                $record->givePermissionTo($key);
                            } else {
                                if ($record->hasPermissionTo($key)) {
                                    $record->revokePermissionTo($key);
                                }
                            }
                        }
                        Notification::make()
                            ->title('Updated successfully')
                            ->success()
                            ->send();
                    })
            ]);
    }
    #[Title('Users')]
    public function render(): View
    {
        return view('livewire.user-management.users');
    }
}
