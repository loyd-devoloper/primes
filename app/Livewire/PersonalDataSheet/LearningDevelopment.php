<?php

namespace App\Livewire\PersonalDataSheet;

use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use App\Models\LearningDevelopment as ModelLearningDevelopment;
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
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;

class LearningDevelopment extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;
    public $count = 0;

    public function headerAddAction()
    {
        return     Action::make('Add')
        ->modalHeading('Add Training / Seminar')
        ->icon('heroicon-o-plus-circle')
        ->form([

            TextInput::make('title')->label('  Title of Learning & Development  ')->required(),


            Grid::make()->schema([
                DatePicker::make('from')->label(' From  ')->required(),
                DatePicker::make('to')->label(' To  ')->required(),
            ]),

            TextInput::make('number_hours')->label(' Number of Hours   ')->numeric(),
            Select::make('type_ld')->label(' Type of Training ( Managerial, Supervisory, Technical ) ')->options([
                'Managerial'=>'Managerial',
                'Supervisory'=>'Supervisory',
                'Technical'=>'Technical',
                'Leadership'=>'Leadership',
            ])->required(),


            TextInput::make('conducted_by')->label('  Conducted / Sponsored By  ')->required(),

            FileUpload::make('attachment')->label(' Upload Certificate ( Upload only PDF file. )')->directory('user/pdf')->acceptedFileTypes(['application/pdf'])->required(),


        ])->action(function ($data) {

            ModelLearningDevelopment::create([
                'id_number' => Auth::user()->id_number,
                'title' => $data['title'] ?? null,
                'from' => $data['from'] ?? null,
                'to' => $data['to'] ?? 'PRESENT',
                'number_hours' => $data['number_hours'] ?? null,
                'type_ld' => $data['type_ld'] ?? null,
                'conducted_by' => $data['conducted_by'] ?? null,
                'attachment' => $data['attachment'] ?? null,
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
        $this->count = ModelLearningDevelopment::query()->select('id_number')->where('id_number', Auth::user()->id_number)->orderBy('to', 'desc')->get()->count();

        return $table

            ->query(ModelLearningDevelopment::query()->where('id_number', Auth::user()->id_number)->orderBy('to', 'desc'))
            ->heading('Learning and Development')
            ->headerActions([
                $this->headerAddAction()
            ])
            ->columns([
                TextColumn::make('title')
                ->label(new HtmlString('TITLE OF LEARNING AND DEVELOPMENT<br>
                INTERVENTION/TRAINING PROGRAMS'))
                ->alignment(Alignment::Center)

                ->wrap()
                ,
                TextColumn::make('INCLUSIVE DATES')->label(new HtmlString(' <div class="grid">
                <h1 style="text-align:center">INCLUSIVE DATES</h1>

            </div>'))->state(function ($record) {
                    return new HtmlString("<div style='padding:0px 10px 0px 0px'>$record->from </div> <strong > TO</strong>  <div style='padding:0px 0px 0px 10px'> $record->to</div>");
                })->extraAttributes(['class' => 'trSplit'])->alignment(Alignment::Center),


                TextColumn::make('number_hours')->label(new HtmlString('# OF HOURS'))->state(function ($record) {

                    return !!$record->number_hours ? $record->number_hours . ' Hours' : null;
                })->alignment(Alignment::Center),
                TextColumn::make('type_ld')->label(new HtmlString('TYPE OF LD<br>
                (MANAGERIAL/<br>
                SUPERVISORY/TECHNICAL)'))
                    ->alignment(Alignment::Center),
                TextColumn::make('conducted_by')->label(new HtmlString('CONDUCTED/<br>SPONSORED BY'))
                    ->alignment(Alignment::Center),


            ])
            ->filters([
                // ...
            ])
            ->actions([

                ActionGroup::make([
                    EditAction::make()

                        ->form([
                            TextInput::make('title')->label('  Title of Learning & Development  ')->required(),


                            Grid::make()->schema([
                                DatePicker::make('from')->label(' From  ')->required(),
                                DatePicker::make('to')->label(' To  ')->required(),
                            ]),

                            TextInput::make('number_hours')->label(' Number of Hours   ')->numeric(),
                            Select::make('type_ld')->label(' Type of Training ( Managerial, Supervisory, Technical ) ')->options([
                                'Managerial'=>'Managerial',
                                'Supervisory'=>'Supervisory',
                                'Technical'=>'Technical',
                                'Leadership'=>'Leadership',
                            ])->required(),

                            TextInput::make('conducted_by')->label('  Conducted / Sponsored By  ')->required(),

                            FileUpload::make('attachment')->label(' Upload Certificate ( Upload only PDF file. )')->directory('user/pdf/')->acceptedFileTypes(['application/pdf'])->required(),

                        ])
                        ->action(function ($data, $record) {
                            ModelLearningDevelopment::where('id', $record->id)->update([

                                'title' => $data['title'] ?? null,
                                'from' => $data['from'] ?? null,
                                'to' => $data['to'] ?? 'PRESENT',
                                'number_hours' => $data['number_hours'] ?? null,
                                'type_ld' => $data['type_ld'] ?? null,
                                'conducted_by' => $data['conducted_by'] ?? null,
                                'attachment' => $data['attachment'] ?? null,
                            ]);
                            sleep(1);
                            Notification::make()
                                ->title('Updated successfully')
                                ->success()
                                ->send();
                        })
                        ->color(Color::Green)->modalWidth(MaxWidth::ExtraLarge),
                    DeleteAction::make(),
                    ViewAction::make()->label('View Certificate')->modalHeading('USER CERTIFICATE')->modalContent(fn ($record) => view('livewire.personal-data-sheet.view-pdf-file', ['link' => $record->attachment])),
                ])    ->label('More actions')
                ->icon('heroicon-m-ellipsis-vertical')->extraAttributes(['title'=>'Actions'])




            ])
            ->bulkActions([
                // ...
            ]);
    }
    #[Title('Learning and Development')]
    public function render()
    {
        return view('livewire.personal-data-sheet.learning-development');
    }
}
