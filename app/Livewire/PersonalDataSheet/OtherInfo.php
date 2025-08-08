<?php

namespace App\Livewire\PersonalDataSheet;

use Filament\Forms\Get;
use Livewire\Component;
use Filament\Forms\Form;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Wizard;
use Illuminate\Support\Facades\Blade;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Contracts\HasActions;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use App\Models\OtherInfo as ModelOtherInfo;

class OtherInfo extends Component implements HasForms, HasInfolists, HasActions
{
    use InteractsWithForms;
    use InteractsWithInfolists;
    use InteractsWithActions;
    use WithFileUploads;
    public $data = [];

    public function mount()
    {
        $check = ModelOtherInfo::where('id_number', Auth::user()->id_number)->first();


        if ($check) {
            $array = $check->toArray();

            $this->form->fill($array);
        } else {
            $this->form->fill([
                'no34_a' => 'N',
                'no34_b' => 'N',
                'no35_a' => 'N',
                'no35_b' => 'N',
                'no36_a' => 'N',
                'no37_a' => 'N',
                'no38_a' => 'N',
                'no38_b' => 'N',
                'no39_a' => 'N',
                'no40_a' => 'N',
                'no40_b' => 'N',
                'no40_c' => 'N',


            ]);
        }
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
             Section::make('Other Information')->schema([
                Wizard::make([
                    Wizard\Step::make('Question')

                        ->schema([
                            Section::make([
                                Radio::make('no34_a')
                                    ->label('A. within the third degree?')
                                    ->inline()
                                    ->inlineLabel(false)
                                    ->options([
                                        'Y' => 'Yes',
                                        'N' => 'No',

                                    ]),
                                Radio::make('no34_b')
                                    ->label('B. within the fourth degree (for Local Government Unit - Career Employees)?')
                                    ->inline()
                                    ->inlineLabel(false)
                                    ->options([
                                        'Y' => 'Yes',
                                        'N' => 'No',

                                    ])
                                    ->live()
                                    ->required(),
                                TextInput::make('no34_b_yes_details')
                                    ->required(fn (Get $get): bool => $get('no34_b') == 'Y' && !!$get('no34_b') ? true : false)
                                    ->label(' If YES, give details: ')

                                    ->disabled(function (Get $get) {

                                        if ($get('no34_b') == 'Y' && !!$get('no34_b')) {

                                            return false;
                                        } else {
                                            $this->data['no34_b_yes_details'] = '';
                                            return true;
                                        }
                                    }),
                            ])->heading('Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be apppointed,'),
                            Section::make([
                                Radio::make('no35_a')
                                    ->label('A Have you ever been found guilty of any administrative offense?')
                                    ->inline()
                                    ->inlineLabel(false)
                                    ->options([
                                        'Y' => 'Yes',
                                        'N' => 'No',

                                    ])
                                    ->live()
                                    ->required(),
                                TextInput::make('no35_a_yes_details')
                                    ->required(fn (Get $get): bool => $get('no35_a') == 'Y' && !!$get('no35_a') ? true : false)
                                    ->label(' If YES, give details: ')

                                    ->disabled(function (Get $get) {

                                        if ($get('no35_a') == 'Y' && !!$get('no35_a')) {

                                            return false;
                                        } else {
                                            $this->data['no35_a_yes_details'] = '';
                                            return true;
                                        }
                                    }),

                                Radio::make('no35_b')
                                    ->label('B. Have you been criminally charged before any court?')
                                    ->inline()
                                    ->inlineLabel(false)
                                    ->options([
                                        'Y' => 'Yes',
                                        'N' => 'No',

                                    ])
                                    ->live()
                                    ->required(),
                                DatePicker::make('no35_b_date_filed')->label(' Date of filed: ')->required(fn (Get $get): bool => $get('no35_b') == 'Y' && !!$get('no35_b') ? true : false)->disabled(function (Get $get) {

                                    if ($get('no35_b') == 'Y' && !!$get('no35_b')) {

                                        return false;
                                    } else {
                                        $this->data['no35_b_date_filed'] = '';
                                        return true;
                                    }
                                }),
                                TextInput::make('no35_b_case_status')
                                    ->required(fn (Get $get): bool => $get('no35_b') == 'Y' && !!$get('no35_b') ? true : false)
                                    ->label(' If YES, give details: ')

                                    ->disabled(function (Get $get) {

                                        if ($get('no35_b') == 'Y' && !!$get('no35_b')) {

                                            return false;
                                        } else {
                                            $this->data['no35_b_case_status'] = '';
                                            return true;
                                        }
                                    }),
                            ]),
                            Section::make([
                                Radio::make('no36_a')
                                    ->label('Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?')
                                    ->inline()
                                    ->inlineLabel(false)
                                    ->options([
                                        'Y' => 'Yes',
                                        'N' => 'No',

                                    ])
                                    ->live()
                                    ->required(),
                                TextInput::make('no36_a_yes_details')
                                    ->required(fn (Get $get): bool => $get('no36_a') == 'Y' && !!$get('no36_a') ? true : false)
                                    ->label(' If YES, give details: ')

                                    ->disabled(function (Get $get) {

                                        if ($get('no36_a') == 'Y' && !!$get('no36_a')) {

                                            return false;
                                        } else {
                                            $this->data['no36_a_yes_details'] = '';
                                            return true;
                                        }
                                    }),
                            ]),
                            Section::make([
                                Radio::make('no37_a')
                                    ->label('Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?')
                                    ->inline()
                                    ->inlineLabel(false)
                                    ->options([
                                        'Y' => 'Yes',
                                        'N' => 'No',

                                    ])
                                    ->live()
                                    ->required(),
                                TextInput::make('no37_a_yes_details')
                                    ->required(fn (Get $get): bool => $get('no37_a') == 'Y' && !!$get('no37_a') ? true : false)
                                    ->label(' If YES, give details: ')

                                    ->disabled(function (Get $get) {

                                        if ($get('no37_a') == 'Y' && !!$get('no37_a')) {

                                            return false;
                                        } else {
                                            $this->data['no37_a_yes_details'] = '';
                                            return true;
                                        }
                                    }),
                            ]),
                            Section::make([
                                Radio::make('no38_a')
                                    ->label('A. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?')
                                    ->inline()
                                    ->inlineLabel(false)
                                    ->options([
                                        'Y' => 'Yes',
                                        'N' => 'No',

                                    ])
                                    ->live()
                                    ->required(),
                                TextInput::make('no38_a_yes_details')
                                    ->required(fn (Get $get): bool => $get('no38_a') == 'Y' && !!$get('no38_a') ? true : false)
                                    ->label(' If YES, give details: ')

                                    ->disabled(function (Get $get) {

                                        if ($get('no38_a') == 'Y' && !!$get('no38_a')) {

                                            return false;
                                        } else {
                                            $this->data['no38_a_yes_details'] = '';
                                            return true;
                                        }
                                    }),

                                Radio::make('no38_b')
                                    ->label('B. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?')
                                    ->inline()
                                    ->inlineLabel(false)
                                    ->options([
                                        'Y' => 'Yes',
                                        'N' => 'No',

                                    ])
                                    ->live()
                                    ->required(),
                                TextInput::make('no38_b_yes_details')
                                    ->required(fn (Get $get): bool => $get('no38_b') == 'Y' && !!$get('no38_b') ? true : false)
                                    ->label(' If YES, give details: ')

                                    ->disabled(function (Get $get) {

                                        if ($get('no38_b') == 'Y' && !!$get('no38_b')) {

                                            return false;
                                        } else {
                                            $this->data['no38_b_yes_details'] = '';
                                            return true;
                                        }
                                    }),
                            ]),
                            Section::make([
                                Radio::make('no39_a')
                                    ->label('Have you acquired the status of an immigrant or permanent resident of another country?')
                                    ->inline()
                                    ->inlineLabel(false)
                                    ->options([
                                        'Y' => 'Yes',
                                        'N' => 'No',

                                    ])
                                    ->live()
                                    ->required(),
                                TextInput::make('no39_a_yes_details')
                                    ->required(fn (Get $get): bool => $get('no39_a') == 'Y' && !!$get('no39_a') ? true : false)
                                    ->label(' If YES, give details: ')

                                    ->disabled(function (Get $get) {

                                        if ($get('no39_a') == 'Y' && !!$get('no39_a')) {

                                            return false;
                                        } else {
                                            $this->data['no39_a_yes_details'] = '';
                                            return true;
                                        }
                                    }),
                            ]),
                            Section::make([
                                Radio::make('no40_a')
                                    ->label('A. Are you a member of any indigenous group?')
                                    ->inline()
                                    ->inlineLabel(false)
                                    ->options([
                                        'Y' => 'Yes',
                                        'N' => 'No',

                                    ]),
                                TextInput::make('no40_a_yes_details')
                                    ->required(fn (Get $get): bool => $get('no40_a') == 'Y' && !!$get('no40_a') ? true : false)
                                    ->label(' If YES, give details: ')

                                    ->disabled(function (Get $get) {

                                        if ($get('no40_a') == 'Y' && !!$get('no40_a')) {

                                            return false;
                                        } else {
                                            $this->data['no40_a_yes_details'] = '';
                                            return true;
                                        }
                                    }),
                                Radio::make('no40_b')
                                    ->label('B. Are you a person with disability?')
                                    ->inline()
                                    ->inlineLabel(false)
                                    ->options([
                                        'Y' => 'Yes',
                                        'N' => 'No',

                                    ])
                                    ->live()
                                    ->required(),
                                TextInput::make('no40_b_yes_details')
                                    ->required(fn (Get $get): bool => $get('no40_b') == 'Y' && !!$get('no40_b') ? true : false)
                                    ->label(' If YES, give details: ')

                                    ->disabled(function (Get $get) {

                                        if ($get('no40_b') == 'Y' && !!$get('no40_b')) {

                                            return false;
                                        } else {
                                            $this->data['no40_b_yes_details'] = '';
                                            return true;
                                        }
                                    }),
                                Radio::make('no40_c')
                                    ->label('C. Are you a solo parent?')
                                    ->inline()
                                    ->inlineLabel(false)
                                    ->options([
                                        'Y' => 'Yes',
                                        'N' => 'No',

                                    ])
                                    ->live()
                                    ->required(),
                                TextInput::make('no40_c_yes_details')
                                    ->required(fn (Get $get): bool => $get('no40_c') == 'Y' && !!$get('no40_c') ? true : false)
                                    ->label(' If YES, give details: ')

                                    ->disabled(function (Get $get) {

                                        if ($get('no40_c') == 'Y' && !!$get('no40_c')) {

                                            return false;
                                        } else {
                                            $this->data['no40_c_yes_details'] = '';
                                            return true;
                                        }
                                    })
                            ])->heading("Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:"),
                        ]),
                    Wizard\Step::make('References')
                        ->schema([
                            Section::make([
                                Group::make([
                                    TextInput::make('c_ref1_name')->label('First name'),
                                    TextInput::make('c_ref1_address')->label('Address'),
                                    TextInput::make('c_ref1_tel')->label('Tel No.'),
                                ])->columns(3),
                                Group::make([
                                    TextInput::make('c_ref2_name')->label('First name'),
                                    TextInput::make('c_ref2_address')->label('Address'),
                                    TextInput::make('c_ref2_tel')->label('Tel No.'),
                                ])->columns(3),
                                Group::make([
                                    TextInput::make('c_ref3_name')->label('First name'),
                                    TextInput::make('c_ref3_address')->label('Address'),
                                    TextInput::make('c_ref3_tel')->label('Tel No.'),
                                ])->columns(3)
                            ])->heading('CHARACTER REFERENCES')
                        ]),
                    Wizard\Step::make('Signature')
                        ->schema([
                            FileUpload::make('e_sig')->label('Signature')->directory('user/signature/')->image()
                        ]),

                ])->submitAction(new HtmlString(new HtmlString(Blade::render(<<<BLADE
            <x-filament::button
                type="submit"

            >
                Submit
            </x-filament::button>
        BLADE))))->skippable(),
             ])

            ])->statePath('data');
    }
    public function store()
    {

        $check = ModelOtherInfo::select('id_number')->where('id_number', Auth::user()->id_number)->first();
        if ($check) {
            ModelOtherInfo::where('id_number', Auth::user()->id_number)
                ->update([
                    'no34_a' => $this->data['no34_a'] ?? null,
                    'no34_b' => $this->data['no34_b'] ?? null,
                    'no35_a' => $this->data['no35_a'] ?? null,
                    'no35_b' => $this->data['no35_b'] ?? null,
                    'no36_a' => $this->data['no36_a'] ?? null,
                    'no37_a' => $this->data['no37_a'] ?? null,
                    'no38_a' => $this->data['no38_a'] ?? null,
                    'no38_b' => $this->data['no38_b'] ?? null,
                    'no39_a' => $this->data['no39_a'] ?? null,
                    'no40_a' => $this->data['no40_a'] ?? null,
                    'no40_b' => $this->data['no40_b'] ?? null,
                    'no40_c' => $this->data['no40_c'] ?? null,
                    'no34_b_yes_details' => $this->data['no34_b_yes_details'] ?? null,
                    'no35_a_yes_details' => $this->data['no35_a_yes_details'] ?? null,
                    'no35_b_date_filed' => $this->data['no35_b_date_filed'] ?? null,
                    'no35_b_case_status' => $this->data['no35_b_case_status'] ?? null,
                    'no36_a_yes_details' => $this->data['no36_a_yes_details'] ?? null,
                    'no37_a_yes_details' => $this->data['no37_a_yes_details'] ?? null,
                    'no38_a_yes_details' => $this->data['no38_a_yes_details'] ?? null,
                    'no38_b_yes_details' => $this->data['no38_b_yes_details'] ?? null,
                    'no39_a_yes_details' => $this->data['no39_a_yes_details'] ?? null,
                    'no40_a_yes_details' => $this->data['no40_a_yes_details'] ?? null,
                    'no40_b_yes_details' => $this->data['no40_b_yes_details'] ?? null,
                    'no40_c_yes_details' => $this->data['no40_c_yes_details'] ?? null,
                    'c_ref1_name' => $this->data['c_ref1_name'] ?? null,
                    'c_ref1_address' => $this->data['c_ref1_address'] ?? null,
                    'c_ref1_tel' => $this->data['c_ref1_tel'] ?? null,
                    'c_ref2_name' => $this->data['c_ref2_name'] ?? null,
                    'c_ref2_address' => $this->data['c_ref2_address'] ?? null,
                    'c_ref2_tel' => $this->data['c_ref2_tel'] ?? null,
                    'c_ref3_name' => $this->data['c_ref3_name'] ?? null,
                    'c_ref3_address' => $this->data['c_ref3_address'] ?? null,
                    'c_ref3_tel' => $this->data['c_ref3_tel'] ?? null,
                ]);

            if (!!$this->form->getState()['e_sig']) {




                ModelOtherInfo::where('id_number', Auth::user()->id_number)
                    ->update([
                        'e_sig' => $this->form->getState()['e_sig']
                    ]);


                // return redirect()->to('/personnel/PersonalInfo');

            } else {
                ModelOtherInfo::where('id_number', Auth::user()->id_number)
                    ->update([
                        'e_sig' => $this->form->getState()['e_sig']
                    ]);
            }
            sleep(1);
            Notification::make()
                ->title('Record Updated successfully')
                ->success()
                ->duration(5000)
                ->send();
        } else {

            ModelOtherInfo::create([
                'id_number' => Auth::user()->id_number,
                'no34_a' => $this->data['no34_a'] ?? null,
                'no34_b' => $this->data['no34_b'] ?? null,
                'no35_a' => $this->data['no35_a'] ?? null,
                'no35_b' => $this->data['no35_b'] ?? null,
                'no36_a' => $this->data['no36_a'] ?? null,
                'no37_a' => $this->data['no37_a'] ?? null,
                'no38_a' => $this->data['no38_a'] ?? null,
                'no38_b' => $this->data['no38_b'] ?? null,
                'no39_a' => $this->data['no39_a'] ?? null,
                'no40_a' => $this->data['no40_a'] ?? null,
                'no40_b' => $this->data['no40_b'] ?? null,
                'no40_c' => $this->data['no40_c'] ?? null,
                'no34_b_yes_details' => $this->data['no34_b_yes_details'] ?? null,
                'no35_a_yes_details' => $this->data['no35_a_yes_details'] ?? null,
                'no35_b_date_filed' => $this->data['no35_b_date_filed'] ?? null,
                'no35_b_case_status' => $this->data['no35_b_case_status'] ?? null,
                'no36_a_yes_details' => $this->data['no36_a_yes_details'] ?? null,
                'no37_a_yes_details' => $this->data['no37_a_yes_details'] ?? null,
                'no38_a_yes_details' => $this->data['no38_a_yes_details'] ?? null,
                'no38_b_yes_details' => $this->data['no38_b_yes_details'] ?? null,
                'no39_a_yes_details' => $this->data['no39_a_yes_details'] ?? null,
                'no40_a_yes_details' => $this->data['no40_a_yes_details'] ?? null,
                'no40_b_yes_details' => $this->data['no40_b_yes_details'] ?? null,
                'no40_c_yes_details' => $this->data['no40_c_yes_details'] ?? null,
                'c_ref1_name' => $this->data['c_ref1_name'] ?? null,
                'c_ref1_address' => $this->data['c_ref1_address'] ?? null,
                'c_ref1_tel' => $this->data['c_ref1_tel'] ?? null,
                'c_ref2_name' => $this->data['c_ref2_name'] ?? null,
                'c_ref2_address' => $this->data['c_ref2_address'] ?? null,
                'c_ref2_tel' => $this->data['c_ref2_tel'] ?? null,
                'c_ref3_name' => $this->data['c_ref3_name'] ?? null,
                'c_ref3_address' => $this->data['c_ref3_address'] ?? null,
                'c_ref3_tel' => $this->data['c_ref3_tel'] ?? null,


            ]);

            if (isset($this->form->getState()['e_sig'])) {




                ModelOtherInfo::where('id_number', Auth::user()->id_number)
                    ->update([
                        'e_sig' => $this->form->getState()['e_sig']
                    ]);


                // return redirect()->to('/personnel/PersonalInfo');

            }
            sleep(1);
            Notification::make()
                ->title('Record Updated successfully')
                ->success()
                ->duration(5000)
                ->send();
        }
    }
    #[Title('Other Information')]
    public function render()
    {
        return view('livewire.personal-data-sheet.other-info');
    }
}
