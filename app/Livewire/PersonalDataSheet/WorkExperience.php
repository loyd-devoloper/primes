<?php

namespace App\Livewire\PersonalDataSheet;

use Filament\Forms\Get;
use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\Facades\Crypt;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Actions\EditAction;
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

class WorkExperience extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;
    public $count = 0;
    public function table(Table $table): Table
    {
        return $table

            ->query(\App\Models\WorkExperience::query()->where('id_number', Auth::user()->id_number)->orderBy('to', 'desc'))
            ->heading('Work Experience')
            ->headerActions([
                Action::make('Add Work Experience')
                    ->icon('heroicon-o-plus-circle')
                    ->form([
                        Fieldset::make('')
                            ->schema([
                                Select::make('status')
                                    ->label('  Work Status ')
                                    ->options(['active' => 'CURRENT',
                                    'pastexp' => 'PAST EXPERIENCE'])->required()->columnSpanFull()->live(),

                                Grid::make()->schema([
                                    DatePicker::make('from')->label('From'),
                                    DatePicker::make('to')->label('To')->hidden(fn (Get $get): bool => ($get('status') == '' || $get('status') == 'pastexp') ? false : true),
                                ])
                            ]),
                        Grid::make()->schema([
                            TextInput::make('position_title')->label('  Position Title  ')->required(),
                            TextInput::make('monthly_salary')->label('  Monthly Salary  ')->numeric(),
                        ]),

                        Grid::make()->schema([
                            TextInput::make('salary_grade')->label('   Salary Grade  ')->numeric()->minValue(0)->maxValue(30),
                            TextInput::make('salary_step')->label(' Salary Step ')->numeric()->minValue(0)->maxValue(10),
                        ]),
                        TextInput::make('company')->label('  Company Name / Department / Agency / Office  ')->required(),

                        // TextInput::make('status_appointment')->label('  Status of Appointment (Permanent, Contractual, Job Order)  ')->required(),
                        Select::make('status_appointment')->options([
                            'Permanent' => 'Permanent',
                            'Contractual' => 'Contractual',
                            'Job Order' => 'Job Order',
                            'Casual' => 'Casual',
                            'Contract of service' => 'Contract of service',
                            'Temporary' => 'Temporary',

                        ])->required(),
                        Radio::make('govt_services')
                            ->label('Government Service ? ')
                            ->boolean()
                            ->inline()
                            ->options([
                                'Y' => 'Yes',
                                'N' => 'No',

                            ])
                            ->default('Y')
                    ])->action(function ($data) {

                        \App\Models\WorkExperience::create([
                            'id_number' => Auth::user()->id_number,
                            'status' => $data['status'] ?? null,
                            'position_title' => $data['position_title'],
                            'monthly_salary' => !!$data['monthly_salary']  ? Crypt::encryptString($data['monthly_salary']) : null,
                            'from' => $data['from'] ?? null,
                            'to' => $data['to'] ?? 'PRESENT',
                            'salary_grade' => $data['salary_grade'] ?? null,
                            'salary_step' => $data['salary_step'] ?? null,
                            'company' => $data['company'] ?? null,

                            'status_appointment' => $data['status_appointment'] ?? null,
                            'govt_services' => $data['govt_services'] ?? null,
                        ]);
                        sleep(1);
                        Notification::make()
                            ->title('Saved successfully')
                            ->success()
                            ->send();
                    })->modalWidth(MaxWidth::ExtraLarge)
            ])
            ->columns([
                TextColumn::make('INCLUSIVE DATES')->label(new HtmlString(' <div class="grid">
                <h1 style="text-align:center">INCLUSIVE DATES</h1>
                <div style="display:flex;justify-content:space-between;padding:10px">
                    <h1>from</h1>
                    <h1>to</h1>
                </div>
            </div>'))->state(function ($record) {
                    return new HtmlString("<div>$record->from </div> <Strong> TO</Strong>  <div> $record->to</div>");
                })->extraAttributes(['class' => 'trSplit'])->alignment(Alignment::Center),
                TextColumn::make('position_title')->label('POSITION TITLE')->alignment(Alignment::Center),
                TextColumn::make('company')->label(new HtmlString('DEPARTMENT/AGENCY/<br>OFFICE/COMPANY'))->alignment(Alignment::Center),
                TextColumn::make('monthly_salary')->label(new HtmlString('MONTHLY<br>SALARY'))->state(function ($record) {

                    return !!$record->monthly_salary ? (int)Crypt::decryptString($record->monthly_salary) : null;
                })->alignment(Alignment::Center),
                TextColumn::make('salary_grade')->label(new HtmlString('SALARY GRADE'))->alignment(Alignment::Center),
                TextColumn::make('salary_step')->label(new HtmlString('STEP'))->alignment(Alignment::Center),
                TextColumn::make('status_appointment')->label(new HtmlString('WORK STATUS'))->alignment(Alignment::Center),


            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {

                        !!$data['monthly_salary'] ? $data['monthly_salary'] = Crypt::decryptString($data['monthly_salary']) : $data['monthly_salary'] = '';

                        return $data;
                    })
                    ->form([
                        Fieldset::make('')
                            ->schema([
                                Select::make('status')
                                    ->label('  Work Status ')
                                    ->options(['active' => 'CURRENT',
                                                  'pastexp' => 'PAST EXPERIENCE'])->required()->columnSpanFull()->live(),

                                Grid::make()->schema([
                                    DatePicker::make('from')->label('From'),
                                    DatePicker::make('to')->label('To')->hidden(fn (Get $get): bool => ($get('status') == '' || $get('status') == 'pastexp') ? false : true),
                                ])
                            ]),
                        Grid::make()->schema([
                            TextInput::make('position_title')->label('  Position Title  ')->required(),
                            TextInput::make('monthly_salary')->label('  Monthly Salary  ')->numeric(),
                        ]),

                        Grid::make()->schema([
                            TextInput::make('salary_grade')->label('   Salary Grade  ')->numeric()->minValue(0)->maxValue(30),
                            TextInput::make('salary_step')->label(' Salary Step ')->numeric()->minValue(0)->maxValue(10),
                        ]),
                        TextInput::make('company')->label('  Company Name / Department / Agency / Office  ')->required(),

                        Select::make('status_appointment')->options([
                            'Permanent' => 'Permanent',
                            'Contractual' => 'Contractual',
                            'Job Order' => 'Job Order',
                            'Casual' => 'Casual',
                            'Contract of service' => 'Contract of service',
                            'Temporary' => 'Temporary',
                        ])->required(),

                        Radio::make('govt_services')
                            ->label('Government Service ? ')
                            ->boolean()
                            ->inline()
                            ->options([
                                'Y' => 'Yes',
                                'N' => 'No',

                            ])
                            ->default(true)
                    ])
                    ->action(function ($data, $record) {
                        \App\Models\WorkExperience::where('id', $record->id)->update([
                            'id_number' => Auth::user()->id_number,
                            'status' => $data['status'] ?? null,
                            'position_title' => $data['position_title'],
                            'monthly_salary' => Crypt::encryptString($data['monthly_salary']) ?? null,
                            'from' => $data['from'] ?? null,
                            'to' => $data['to'] ?? 'PRESENT',
                            'salary_grade' => $data['salary_grade'] ?? null,
                            'salary_step' => $data['salary_step'] ?? null,
                            'company' => $data['company'] ?? null,

                            'status_appointment' => $data['status_appointment'] ?? null,
                            'govt_services' => $data['govt_services'] ?? null,
                        ]);
                        sleep(1);
                        Notification::make()
                            ->title('Saved successfully')
                            ->success()
                            ->send();
                    })
                    ->color(Color::Green)->modalWidth(MaxWidth::ExtraLarge),
                DeleteAction::make(),

            ])
            ->bulkActions([
                // ...
            ])->paginationPageOptions([
                5,10,20
            ]);
    }
    #[Title('Work Experience')]
    public function render()
    {


        return view('livewire.personal-data-sheet.work-experience');
    }
}
