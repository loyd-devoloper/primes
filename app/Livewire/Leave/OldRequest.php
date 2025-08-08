<?php

namespace App\Livewire\Leave;

use Filament\Tables;
use App\Models\users;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class OldRequest extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->heading('History')
            ->query(\App\Models\User::query())
            ->columns([
                TextColumn::make('name')->state(fn() => 'SPL - G. Dela Torre')->searchable(),
                TextColumn::make('type')->state(fn() => 'SPL'),
                TextColumn::make('Request Date')->state(fn() => 'Dec 10, 2024'),
            ])
          ;
    }

    public function render(): View
    {
        return view('livewire.leave.old-request');
    }
}
