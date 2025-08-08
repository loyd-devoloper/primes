<?php

namespace App\Livewire\PersonalDataSheet;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Children;
use Filament\Tables\Table;

use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;

class EducationalBackground extends Component implements HasForms, HasTable, HasActions
{

    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;
    public function table(Table $table): Table
    {
        return $table

            ->query(\App\Models\EducationBackground::query()->where('id_number', Auth::user()->id_number))
            ->heading('Educational Background')
            ->headerActions([
                Action::make('Add')
                    ->icon('heroicon-o-plus-circle')
                    ->form([
                        Select::make('level')
                            ->label(' Educational Level')
                            ->options([
                                'ELEMENTARY' => 'ELEMENTARY',
                                'SECONDARY' => 'SECONDARY',
                                'VOCATIONAL' => 'VOCATIONAL',
                                'COLLEGE' => 'COLLEGE',
                                'GRADUATE STUDIES' => 'GRADUATE STUDIES',
                            ])->required(),
                        Grid::make()->schema([
                            TextInput::make('school_name')->label(' Name of School ')->required(),
                            TextInput::make('course_education')->label(' Basic Education / Degree / Course ')->required(),


                        ]),


                        Fieldset::make(' PERIOD OF ATTENDANCE ')
                            ->schema([
                                TextInput::make('from')->required()->numeric()->minValue(1900),
                                TextInput::make('to')->required()->numeric()->minValue(1900),

                            ])
                            ->columns(2),

                        TextInput::make('unit_earned')->label(new HtmlString('<span> HIGHEST LEVEL/UNITS EARNED</span><span class="text-gray-500">
(if not graduated) </span>'))->numeric(),
                        TextInput::make('year_graduated')->label('  Year Graduated  ')->numeric(),

                        TextInput::make('academic_honor_received')->label('academic_honor_received'),
                    ])->action(function ($data) {
                        $data = \App\Models\EducationBackground::create([
                            'id_number' => Auth::user()->id_number,
                            'level' => $data['level'],
                            'school_name' => $data['school_name'],
                            'course_education' => $data['course_education'],
                            'from' => $data['from'],
                            'to' => $data['to'],
                            'unit_earned' => $data['unit_earned'],
                            'year_graduated' => $data['year_graduated'],
                            'academic_honor_received' => $data['academic_honor_received'],
                        ]);
                        $name = Auth::user()->name;
                        Log::info("PDS: $name ADD EDUCATION BACKGROUND");
                        Log::info("DATA: $data");
                        sleep(1);
                        Notification::make()
                            ->title('Saved successfully')
                            ->success()
                            ->send();
                    })->modalWidth(MaxWidth::ExtraLarge)
            ])
            ->columns([
                TextColumn::make('level')->label('LEVEL'),
                TextColumn::make('school_name')->label(new HtmlString('NAME OF <br> SCHOOL')),

                TextColumn::make('course_education')->label(new HtmlString('BASIC EDUCATION/<br>
                DEGREE/COURSE ')),
                TextColumn::make('PERIOD OF ATTENDANCE')->label(new HtmlString(' <div class="grid">
                <h1>PERIOD OF ATTENDANCE</h1>
                <div style="display:flex;justify-content:space-between;padding:10px 23px;opacity:.7">
                    <h1>from</h1>
                    <h1>to</h1>
                </div>
            </div>'))->state(function ($record) {
                    return new HtmlString("<div>$record->from </div> TO  <div> $record->to</div>");
                })->extraAttributes(['class' => 'trSplit']),

                // TextColumn::make('from')->label(new HtmlString(' PERIOD OF<br> ATTENDANCE'))->state(function($record){
                //     return new HtmlString($record->from.' TO '. $record->to);
                // }),
                TextColumn::make('to')->label(new HtmlString('PERIOD OF<br> ATTENDANCE')),
                TextColumn::make('unit_earned')->label(new HtmlString('HIGHEST LEVEL
                <br>UNITS EARNED')),
                TextColumn::make('year_graduated')->label('  YEAR
                GRADUATED'),

            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make()
                    ->form([
                        Select::make('level')
                            ->label(' Educational Level')
                            ->options([
                                'ELEMENTARY' => 'ELEMENTARY',
                                'SECONDARY' => 'SECONDARY',
                                'VOCATIONAL' => 'VOCATIONAL',
                                'COLLEGE' => 'COLLEGE',
                                'GRADUATE STUDIES' => 'GRADUATE STUDIES',
                            ])->required(),
                        Grid::make()->schema([
                            TextInput::make('school_name')->label(' Name of School ')->required(),
                            TextInput::make('course_education')->label(' Basic Education / Degree / Course ')->required(),


                        ]),
                        Fieldset::make(' PERIOD OF ATTENDANCE ')
                            ->schema([
                                TextInput::make('from')->required()->numeric()->minValue(1900),
                                TextInput::make('to')->required()->numeric()->minValue(1900),

                            ])
                            ->columns(2),
                        Grid::make()->schema([
                            TextInput::make('unit_earned')->label(' Unit Earned ')->numeric(),
                            TextInput::make('year_graduated')->label('  Year Graduated  ')->numeric(),
                        ]),
                        TextInput::make('academic_honor_received')->label('academic_honor_received'),
                    ])
                    ->action(function ($data, $record) {
                        \App\Models\EducationBackground::where('id', $record->id)->update([
                            'id_number' => Auth::user()->id_number,
                            'level' => $data['level'],
                            'school_name' => $data['school_name'],
                            'course_education' => $data['course_education'],
                            'from' => $data['from'],
                            'to' => $data['to'],
                            'unit_earned' => $data['unit_earned'],
                            'year_graduated' => $data['year_graduated'],
                            'academic_honor_received' => $data['academic_honor_received'],
                        ]);
                        $name = Auth::user()->name;
                        Log::info("PDS: $name EDIT EDUCATION BACKGROUND");
                        Log::info("DATA: $record");
                        sleep(1);
                        Notification::make()
                            ->title('Saved successfully')
                            ->success()
                            ->send();
                    })
                    ->color(Color::Green)->modalWidth(MaxWidth::ExtraLarge),
                DeleteAction::make()->action(function ($record){
                    $name = Auth::user()->name;
                    Log::info("PDS: $name DELETE EDUCATION BACKGROUND");
                    Log::info("DATA: $record");
                    $record->delete();
                    sleep(1);
                    Notification::make()
                        ->title('Deleted successfully')
                        ->success()
                        ->send();
                }),

            ])
            ->bulkActions([
                // ...
            ]);
    }
    #[Title('Educational Background')]
    public function render()
    {
        return view('livewire.personal-data-sheet.educational-background');
    }
}
