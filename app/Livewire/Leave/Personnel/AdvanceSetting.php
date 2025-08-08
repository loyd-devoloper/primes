<?php

namespace App\Livewire\leave\personnel;

use Filament\Forms;
use App\Models\User;
use Livewire\Component;
use Filament\Forms\Form;
use Livewire\Attributes\Title;
use Filament\Forms\Components\Grid;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Group;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;

class AdvanceSetting extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public function mount(): void
    {
        $arr = \App\Models\Leave\LeaveAdvanceSetting::first();

        if ($arr) {
            $this->form->fill($arr?->toArray());
        }
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'default' => 1,
                    'sm' => 4,
                ])
                    ->schema([
                        // days
                        Group::make([
                            Fieldset::make('Minutes')
                                ->schema([
                                    Grid::make([
                                        'default' => 4,

                                    ])
                                        ->schema([
                                            // first row
                                            TextInput::make('min1')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('1'),
                                            TextInput::make('min16')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('16'),
                                            TextInput::make('min31')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('31'),
                                            TextInput::make('min46')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('46'),
                                            // second row
                                            TextInput::make('min2')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('2'),
                                            TextInput::make('min17')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('17'),
                                            TextInput::make('min32')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('32'),
                                            TextInput::make('min47')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('47'),
                                            // third row
                                            TextInput::make('min3')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('3'),
                                            TextInput::make('min18')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('18'),
                                            TextInput::make('min33')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('33'),
                                            TextInput::make('min48')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('48'),
                                            // 4th row
                                            TextInput::make('min4')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('4'),
                                            TextInput::make('min19')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('19'),
                                            TextInput::make('min34')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('34'),
                                            TextInput::make('min49')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('49'),
                                            // 5th row
                                            TextInput::make('min5')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('5'),
                                            TextInput::make('min20')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('20'),
                                            TextInput::make('min35')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('35'),
                                            TextInput::make('min50')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('50'),
                                            // 6th row
                                            TextInput::make('min6')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('6'),
                                            TextInput::make('min21')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('21'),
                                            TextInput::make('min36')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('36'),
                                            TextInput::make('min51')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('51'),
                                            // 7th row
                                            TextInput::make('min7')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('7'),
                                            TextInput::make('min22')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('22'),
                                            TextInput::make('min37')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('37'),
                                            TextInput::make('min52')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('52'),
                                            // 8th row
                                            TextInput::make('min8')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('8'),
                                            TextInput::make('min23')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('23'),
                                            TextInput::make('min38')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('38'),
                                            TextInput::make('min53')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('53'),
                                            // 9th row
                                            TextInput::make('min9')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('9'),
                                            TextInput::make('min24')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('24'),
                                            TextInput::make('min39')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('39'),
                                            TextInput::make('min54')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('54'),
                                            // 10th row
                                            TextInput::make('min10')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('10'),
                                            TextInput::make('min25')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('25'),
                                            TextInput::make('min40')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('40'),
                                            TextInput::make('min55')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('55'),
                                            // 10th row
                                            TextInput::make('min11')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('11'),
                                            TextInput::make('min26')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('26'),
                                            TextInput::make('min41')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('41'),
                                            TextInput::make('min56')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('56'),
                                            // 11th row
                                            TextInput::make('min12')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('12'),
                                            TextInput::make('min27')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('27'),
                                            TextInput::make('min42')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('42'),
                                            TextInput::make('min57')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('57'),
                                            // 12th row
                                            TextInput::make('min13')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('13'),
                                            TextInput::make('min28')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('28'),
                                            TextInput::make('min43')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('43'),
                                            TextInput::make('min58')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('58'),
                                            // 13th row
                                            TextInput::make('min14')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('14'),
                                            TextInput::make('min29')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('29'),
                                            TextInput::make('min44')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('44'),
                                            TextInput::make('min59')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('59'),
                                            // 13th row
                                            TextInput::make('min15')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('15'),
                                            TextInput::make('min30')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('30'),
                                            TextInput::make('min45')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('45'),
                                            TextInput::make('min60')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('60'),
                                        ])->extraAttributes(['class' => '!gap-0'])

                                ]),
                        ])->columnSpan(2),
                        // hours
                        Group::make([
                            Fieldset::make('Hours')
                                ->schema([
                                    Grid::make([
                                        'default' => 1,

                                    ])
                                        ->schema([
                                            TextInput::make('hours1')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('1'),
                                            TextInput::make('hours2')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('2'),
                                            TextInput::make('hours3')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('3'),
                                            TextInput::make('hours4')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('4'),
                                            TextInput::make('hours5')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('5'),
                                            TextInput::make('hours6')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('6'),
                                            TextInput::make('hours7')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('7'),
                                            TextInput::make('hours8')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('8'),
                                            TextInput::make('hours9')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('9'),
                                            TextInput::make('hours10')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('10'),
                                        ])
                                ]),
                        ]),
                        // Month
                        Group::make([
                            Fieldset::make('Month')
                                ->schema([
                                    Grid::make([
                                        'default' => 1,

                                    ])
                                        ->schema([
                                            TextInput::make('month1')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('1'),
                                            TextInput::make('month2')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('2'),
                                            TextInput::make('month3')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('3'),
                                            TextInput::make('month4')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('4'),
                                            TextInput::make('month5')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('5'),
                                            TextInput::make('month6')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('6'),
                                            TextInput::make('month7')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('7'),
                                            TextInput::make('month8')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('8'),
                                            TextInput::make('month9')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('9'),
                                            TextInput::make('month10')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('10'),
                                            TextInput::make('month11')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('11'),
                                            TextInput::make('month12')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('12'),
                                        ])

                                ]),
                        ]),
                        // Days
                        Group::make([
                            Fieldset::make('Days')
                                ->schema([
                                    Grid::make([
                                        'default' => 5,

                                    ])
                                        ->schema([
                                            // row 1
                                            TextInput::make('days1')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('1'),
                                            TextInput::make('days7')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('7'),
                                            TextInput::make('days13')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('13'),
                                            TextInput::make('days19')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('19'),
                                            TextInput::make('days25')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('25'),
                                            // row 2
                                            TextInput::make('days2')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('2'),
                                            TextInput::make('days8')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('8'),
                                            TextInput::make('days14')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('14'),
                                            TextInput::make('days20')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('20'),
                                            TextInput::make('days26')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('26'),
                                            // row 3
                                            TextInput::make('days3')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('3'),
                                            TextInput::make('days9')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('9'),
                                            TextInput::make('days15')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('15'),
                                            TextInput::make('days21')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('21'),
                                            TextInput::make('days27')
                                                ->label(false)
                                                ->numeric()
                                                ->step('any')
                                                ->prefix('27'),
                                             // row 4
                                             TextInput::make('days4')
                                             ->label(false)
                                                ->numeric()
                                                ->step('any')
                                             ->prefix('4'),
                                         TextInput::make('days10')
                                             ->label(false)
                                                ->numeric()
                                                ->step('any')
                                             ->prefix('10'),
                                         TextInput::make('days16')
                                             ->label(false)
                                                ->numeric()
                                                ->step('any')
                                             ->prefix('16'),
                                         TextInput::make('days22')
                                             ->label(false)
                                                ->numeric()
                                                ->step('any')
                                             ->prefix('22'),
                                         TextInput::make('days28')
                                             ->label(false)
                                                ->numeric()
                                                ->step('any')
                                             ->prefix('28'),
                                              // row 5
                                              TextInput::make('days5')
                                              ->label(false)
                                                ->numeric()
                                                ->step('any')
                                              ->prefix('5'),
                                          TextInput::make('days11')
                                              ->label(false)
                                                ->numeric()
                                                ->step('any')
                                              ->prefix('11'),
                                          TextInput::make('days17')
                                              ->label(false)
                                                ->numeric()
                                                ->step('any')
                                              ->prefix('17'),
                                          TextInput::make('days23')
                                              ->label(false)
                                                ->numeric()
                                                ->step('any')
                                              ->prefix('23'),
                                          TextInput::make('days29')
                                              ->label(false)
                                                ->numeric()
                                                ->step('any')
                                              ->prefix('29'),
                                            // row 6
                                            TextInput::make('days6')
                                            ->label(false)
                                                ->numeric()
                                                ->step('any')
                                            ->prefix('6'),
                                        TextInput::make('days12')
                                            ->label(false)
                                                ->numeric()
                                                ->step('any')
                                            ->prefix('12'),
                                        TextInput::make('days18')
                                            ->label(false)
                                                ->numeric()
                                                ->step('any')
                                            ->prefix('18'),
                                        TextInput::make('days24')
                                            ->label(false)
                                                ->numeric()
                                                ->step('any')
                                            ->prefix('24'),
                                        TextInput::make('days30/31')
                                            ->label(false)
                                                ->numeric()
                                                ->step('any')
                                            ->prefix('30/31'),

                                        ])->extraAttributes(['class' => '!gap-0'])
                                ]),
                        ])->columnSpanFull(),

                    ])

            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        \App\Models\Leave\LeaveAdvanceSetting::updateOrCreate(['id'=>1],$data);

        Notification::make()
        ->title('Updated successfully')
        ->success()
        ->send();

    }
    #[Title('Advance Setting')]
    public function render(): View
    {
        return view('livewire.leave.personnel.advance-setting');
    }
}
