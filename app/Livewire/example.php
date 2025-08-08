<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Widgets\TableWidget as BaseWidget;

class example extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
               User::query()
            )
            ->columns([
                TextColumn::make('name')
            ])
            ->actions([
                EditAction::make('ctos')->extraAttributes(['id' => 'update-author-modal'])->form([
                    TextInput::make('name')
                ])
            ]);
    }
}
