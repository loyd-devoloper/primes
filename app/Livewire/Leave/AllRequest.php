<?php

namespace App\Livewire\Leave;

use App\Models\User;
use Livewire\Component;
use Filament\Tables\Table;
use App\Models\Shop\Product;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;


class AllRequest extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query()->select('id', 'name', 'id_number', 'employee_id', 'fd_code','profile')->with(['user_fd_code']))
            ->columns([

                TextColumn::make('name')->searchable(),
                TextColumn::make('user_fd_code.division_name')->label('Unit/Division')->searchable(),
            ])

            ->actions([
                Action::make(' Employee Leave')
                ->url(fn($record) => route('leave.employees.view',['employee_id'=>$record->id_number]))->icon('heroicon-o-arrow-long-right')

            ]);

    }
    public function render()
    {
        return view('livewire.leave.all-request');
    }
}
