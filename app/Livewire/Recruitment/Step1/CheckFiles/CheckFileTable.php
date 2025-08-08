<?php

namespace App\Livewire\Recruitment\Step1\CheckFile;

use App\Models\User;
use Mpdf\Tag\TextArea;
use Filament\Forms\Get;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\View;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Wizard;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\Route;
use Filament\Forms\Components\Builder;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\KeyValue;
use Filament\Infolists\Components\Tabs;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class CheckFileTable extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public $job_title = '';


    public function mount($job_title, $id)
    {
        $this->job_title = $job_title;

    }

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())

            ->columns([
                TextColumn::make('name')->label('Applicant Name')->searchable(),
            ])
            ->filters([
                Filter::make('search')

                ->label('Search')

                ->query(function (Builder $query, string $search): Builder {

                    return $query

                        ->where('first_name', 'like', "%{$search}%")

                        ->orWhere('last_name', 'like', "%{$search}%")

                        ->orWhere('email', 'like', "%{$search}%");

                }),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('View')->icon('heroicon-o-eye')->color(Color::Blue)

                        ->url(fn ($record) => "/personnel/recruitment/step1/checkfile/applicant/" . $record->id),

                    Action::make('Activity Logs')->icon('heroicon-o-clock')->color(Color::Yellow),
                    Action::make('Open')->form([
                        Wizard::make([
                            Wizard\Step::make('Applicant Information')
                                ->schema([
                                    // ...
                                ]),
                            Wizard\Step::make('Step 1')
                                ->schema([


                                    Grid::make(5)->schema([

                                        ViewField::make('s')->view('bio')->columnSpan(4),

                                        \Filament\Forms\Components\Actions::make([
                                            \Filament\Forms\Components\Actions\Action::make('x')
                                                ->label('view')
                                                ->icon('heroicon-o-eye')

                                                ->modalContent(function ($record) {
                                                    $link = 'user/pdf/01HZ66MHAMMXYVGQ9FA63MCRV1.pdf';
                                                    return view('livewire.recruitment.step1.check-file.pdf-viewer', compact('link'));
                                                })
                                                ->modalSubmitAction(false)
                                                ->modalCancelAction(false)
                                                ->modalWidth(MaxWidth::ScreenExtraLarge)

                                                ->action(function () {
                                                })->closeModalByClickingAway(false),
                                            \Filament\Forms\Components\Actions\Action::make('customAction2')
                                                ->iconButton()
                                                ->color(Color::Green)
                                                ->icon('heroicon-o-check')
                                                ->action(function () {
                                                }),
                                            \Filament\Forms\Components\Actions\Action::make('customAction3')
                                                ->iconButton()
                                                ->color(Color::Red)
                                                ->icon('heroicon-o-x-mark')
                                                ->action(function () {
                                                }),
                                        ])

                                    ]),


                                ]),

                        ])->skippable()->submitAction(new HtmlString('<button type="submit">Submit</button>'))->startOnStep(2)

                    ])->modalWidth(MaxWidth::ScreenExtraLarge)->modalSubmitAction(false)->modalCancelAction(false)->closeModalByClickingAway(false)

                ])
            ])->paginationPageOptions(['5', '10', '20', '30', 'all']);
    }
    public function render()
    {



        return view('livewire.recruitment.step1.check-file.check-file-table');
    }


}
