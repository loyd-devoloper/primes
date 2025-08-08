<?php

namespace App\Livewire\PersonalDataSheet;

use App\Models\VoluntaryWork;
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

class AffiliationInvolvement extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;
    public $count = 0;
    public function headerAddAction()
    {


        return  Action::make('Add')
        ->icon('heroicon-o-plus-circle')
        ->form([

            Grid::make()->schema([
                TextInput::make('name_organization')->label('  Name of Organization   ')->required(),
                TextInput::make('address_organization')->label('  Address of Organization   ')->required(),
            ]),
            Grid::make()->schema([
                DatePicker::make('from')->label(' From ')->required(),
                DatePicker::make('to')->label(' To ')->required(),
            ]),
            Grid::make()->schema([
                TextInput::make('number_hours')->label(' Number of Hours   ')->numeric(),
                TextInput::make('position')->label(' Position ')->required(),
            ]),


            TextInput::make('nature_work')->label(' Nature of Work '),


        ])->action(function ($data) {

            VoluntaryWork::create([
                'id_number' => Auth::user()->id_number,
                'name_organization' => $data['name_organization'] ?? null,
                'address_organization' => $data['address_organization'] ?? null,

                'from' => $data['from'] ?? null,
                'to' => $data['to'] ?? 'PRESENT',
                'number_hours' => $data['number_hours'] ?? null,
                'position' => $data['position'] ?? null,
                'nature_work' => $data['nature_work'] ?? null,
            ]);
            sleep(1);
            Notification::make()
                ->title('Saved successfully')
                ->success()
                ->send();
        })->modalWidth(MaxWidth::ExtraLarge);
    }
    public function table(Table $table): Table
    {
        $this->count = VoluntaryWork::query()->select('id_number')->where('id_number', Auth::user()->id_number)->get()->count();

        return $table

            ->query(VoluntaryWork::query()->where('id_number', Auth::user()->id_number)->orderBy('to', 'desc'))
            ->heading('Voluntary Work or Involvement')
            ->headerActions([
               $this->headerAddAction()
            ])
            ->columns([
                TextColumn::make('name_organization')->label(new HtmlString('NAME & ADDRESS <br>OF ORGANIZATION'))
                    ->alignment(Alignment::Center)
                    ->state(function ($record) {

                        return new HtmlString("<h1><strong>$record->name_organization</strong></h1>
                                                                            <p>$record->address_organization</p>");
                    }),
                TextColumn::make('INCLUSIVE DATES')->label(new HtmlString(' <div class="grid">
                <h1 style="text-align:center">INCLUSIVE DATES</h1>

            </div>'))->state(function ($record) {
                    return new HtmlString("<div>$record->from </div> <Strong> TO</Strong>  <div> $record->to</div>");
                })->extraAttributes(['class' => 'trSplit'])->alignment(Alignment::Center),


                TextColumn::make('number_hours')->label(new HtmlString('# OF HOURS'))->state(function ($record) {

                    return !!$record->number_hours ? $record->number_hours . ' Hours' : null;
                })->alignment(Alignment::Center),
                TextColumn::make('salary_grade')->label(new HtmlString('POSITION /<br>NATURE OF WORK'))
                    ->alignment(Alignment::Center)
                    ->state(function ($record) {
                        return new HtmlString("<h1><strong>$record->position</strong></h1>
                                                                            <p>$record->nature_work</p>");
                    }),



            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make()

                    ->form([
                        Grid::make()->schema([
                            TextInput::make('name_organization')->label('  Name of Organization   ')->required(),
                            TextInput::make('address_organization')->label('  Address of Organization   ')->required(),
                        ]),
                        Grid::make()->schema([
                            DatePicker::make('from')->label(' From ')->required(),
                            DatePicker::make('to')->label(' To ')->required(),
                        ]),
                        Grid::make()->schema([
                            TextInput::make('number_hours')->label(' Number of Hours   ')->numeric(),
                            TextInput::make('position')->label(' Position ')->required(),
                        ]),


                        TextInput::make('nature_work')->label(' Nature of Work '),

                    ])
                    ->action(function ($data, $record) {
                        VoluntaryWork::where('id',$record->id)->update([

                            'name_organization' => $data['name_organization'] ?? null,
                            'address_organization' => $data['address_organization'] ?? null,

                            'from' => $data['from'] ?? null,
                            'to' => $data['to'] ?? 'PRESENT',
                            'number_hours' => $data['number_hours'] ?? null,
                            'position' => $data['position'] ?? null,
                            'nature_work' => $data['nature_work'] ?? null,
                        ]);
                        sleep(1);
                        Notification::make()
                            ->title('Updated successfully')
                            ->success()
                            ->send();
                    })
                    ->color(Color::Green)->modalWidth(MaxWidth::ExtraLarge),
                DeleteAction::make(),

            ])
            ->bulkActions([
                // ...
            ]);
    }
    #[Title('Voluntary Work or Involvement')]
    public function render()
    {


        return view('livewire.personal-data-sheet.affiliation-involvement');
    }
}
