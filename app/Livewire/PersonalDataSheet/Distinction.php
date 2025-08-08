<?php

namespace App\Livewire\PersonalDataSheet;

use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Distinction extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\Distinction::query()->where('id_number',Auth::user()->id_number)->orderBy('year','desc'))
            ->heading('NON-ACADEMIC DISTINCTIONS / RECOGNITION')
            ->headerActions([
                Action::make('add')->modalHeading('Add Recognition')->form([
                    TextInput::make('distinction')->label(' NON-ACADEMIC DISTINCTIONS / RECOGNITION ')->required(),
                    TextInput::make('agency')->label('Agency')->required(),
                    DatePicker::make('year')->required(),
                    FileUpload::make('file')->label('Upload Documents  ( Upload only PDF file. )')->directory('user/distinction/')->acceptedFileTypes(['application/pdf'])->required(),
                    // TextInput::make('membership_organization')->label(' MEMBERSHIP IN ASSOCIATION/ORGANIZATION  '),
                ])->modalWidth(MaxWidth::Medium)->action(function ($data) {
                    \App\Models\Distinction::create([
                        'distinction' => $data['distinction'],
                        'agency' => $data['agency'],
                        'file' => $data['file'],
                        'year' => $data['year'],
                        'id_number' => Auth::user()->id_number,
                    ]);
                    sleep(1);
                    Notification::make()
                        ->title('Created successfully')
                        ->success()
                        ->send();
                })
            ])
            ->columns([
                TextColumn::make('distinction'),
                TextColumn::make('agency'),
                TextColumn::make('year'),

            ])
            ->filters([
                // ...
            ])
            ->actions([
                ViewAction::make()->label('View Recognition')->modalHeading('User Recognition')->modalContent(fn ($record) => view('livewire.personal-data-sheet.view-pdf-file', ['link' => $record->file])),
                EditAction::make()->form([
                    TextInput::make('distinction')->label(' NON-ACADEMIC DISTINCTIONS / RECOGNITION ')->required(),
                    TextInput::make('agency')->label('Agency')->required(),
                    DatePicker::make('year')->required(),
                    FileUpload::make('file')->label('Upload Documents  ( Upload only PDF file. )')->directory('user/distinction/')->acceptedFileTypes(['application/pdf'])->required(),
                    // TextInput::make('membership_organization')->label(' MEMBERSHIP IN ASSOCIATION/ORGANIZATION  '),
                ])->modalWidth(MaxWidth::Medium)->action(function ($data, $record) {
                    $record->update([
                        'distinction' => $data['distinction'],
                        'agency' => $data['agency'],
                        'file' => $data['file'],
                        'year' => $data['year'],
                    ]);
                    sleep(1);
                    Notification::make()
                        ->title('Updated successfully')
                        ->success()
                        ->send();
                })->color(Color::Green),
                DeleteAction::make()
            ])
            ->bulkActions([
                // ...
            ]);
    }
    #[Title('NON-ACADEMIC DISTINCTIONS / RECOGNITION')]
    public function render()
    {
        return view('livewire.personal-data-sheet.distinction');
    }
}
