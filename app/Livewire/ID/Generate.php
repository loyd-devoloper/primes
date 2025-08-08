<?php

namespace App\Livewire\ID;

use Livewire\Component;
use App\Models\Director;
use Filament\Actions\Action;


use Barryvdh\DomPDF\PDF;
use Filament\Forms\Form;
use App\Models\ID_Template;
use App\Models\ID_Attribute;

use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
class Generate extends Component
{


    public $data = [
        'front' => '',
        'back' => '',

    ];

    public $activeTemplate;
    public $currentTemplate = [];
    public $attributes_data = [];
    public $attributesData = [];

    public function modalFormAction() : Action
    {
        return   Action::make('modalForm')
            ->label('Add Template ')
            ->icon('heroicon-o-plus')
            ->modalHeading('Add Template')
            ->form([

                TextInput::make('name')->label('First name')->required(),

                Grid::make(2)
                ->schema([
                    FileUpload::make('front')->label('FRONT')->directory('id_template/front/')->required()->maxWidth(MaxWidth::ExtraSmall),
                    FileUpload::make('back')->label('BACK')->directory('id_template/back/')->maxWidth(MaxWidth::ExtraSmall),
                ]),

                Fieldset::make('Attributes_Front')->schema([
                    Toggle::make('firstname_f')->label('First Name')->inline()->live()->default(true),
                    Toggle::make('middlename_f')->label('Middle Name')->inline()->live()->default(true),
                    Toggle::make('lastname_f')->label('Last Name')->inline()->live()->default(true),
                    Toggle::make('qr_code_f')->label('QR CODE')->inline()->live(),
                    Toggle::make('profile_f')->label('Profile')->inline()->live()->default(true),
                    Toggle::make('e_sig_f')->label('Signature')->inline()->live(),
                    // Toggle::make('address_f')->label('Address')->inline()->live(),
                    Toggle::make('position_f')->label('Position')->inline()->live()->default(true),
                    Toggle::make('office_name_f')->label('Office Name')->inline()->live()->default(true),
                    Toggle::make('employee_id_f')->label('Employee ID')->inline()->live()->default(true),
                    Toggle::make('region_f')->label('Region IV-A CALABARZON')->inline()->live()->default(true),

                ])->statePath('attributes_data_f'),
                Fieldset::make('Attributes_Back')->schema([
                    Toggle::make('fullname_b')->label('Fullname')->inline()->live()->default(true),
                    Toggle::make('director_b')->label('Director')->inline()->live()->default(true),
                    Toggle::make('qr_code_b')->label('QR CODE')->inline()->live()->default(true),
                    Toggle::make('e_sig_b')->label('Signature')->inline()->live()->default(true),


                    Toggle::make('emergency_b')->label('Emergency Name/Contact')->inline()->live()->default(true),
                ])->statePath('attributes_data_b')
            ])


            ->action(function (array $data) {

                $template_json = [];
                $attribute_position = [];
                foreach($data['attributes_data_f'] as $key => $value)
                {
                     if($value)
                     {
                        $template_json[] = $key;
                        $attribute_position[$key] = [
                            'font_size'=>30,
                            'text_color'=>'black',
                            'font_bold'=>'normal',
                            'position'=>[
                                'x'=>296,
                                'y'=>-0
                            ],
                            'width'=>null,
                            'height'=>null
                        ];
                     }
                }
                foreach($data['attributes_data_b'] as $key => $value)
                {
                     if($value)
                     {

                        if($key == 'director_b')
                        {
                            $template_json[] = 'director_esig_b';
                            $attribute_position['director_esig_b'] = [
                                'font_size'=>30,
                                'text_color'=>'black',
                                'font_bold'=>'normal',
                                'position'=>[
                                    'x'=>-150,
                                    'y'=>-1
                                ],
                                'width'=>null,
                                'height'=>null
                            ];
                            $template_json[] = 'director_name_b';
                            $attribute_position['director_name_b'] = [
                                'font_size'=>30,
                                'text_color'=>'black',
                                'font_bold'=>'normal',
                                'position'=>[
                                    'x'=>-150,
                                    'y'=>-1
                                ],
                                'width'=>null,
                                'height'=>null
                            ];
                            $template_json[] = 'director_position_b';
                            $attribute_position['director_position_b'] = [
                                'font_size'=>30,
                                'text_color'=>'black',
                                'font_bold'=>'normal',
                                'position'=>[
                                    'x'=>-150,
                                    'y'=>-1
                                ],
                                'width'=>null,
                                'height'=>null
                            ];

                        }else{
                            $template_json[] = $key;
                            $attribute_position[$key] = [
                                'font_size'=>30,
                                'text_color'=>'black',
                                'font_bold'=>'normal',
                                'position'=>[
                                    'x'=>-150,
                                    'y'=>-1
                                ],
                                'width'=>null,
                                'height'=>null
                            ];
                        }


                     }
                }
                $template = ID_Template::create(['name' => $data['name'],   'attribute'=>json_encode($template_json)]);

                $template->update([
                    'front' => $data['front'],


                ]);
              ID_Attribute::create(['id_template' =>  $template->id,   'attribute'=>json_encode($attribute_position)]);
                if(!!$data['back'])
                {
                    $template->update([
                        'back'=>$data['back']
                    ]);
                }

                sleep(1);
                Notification::make()
                    ->title('Saved successfully')
                    ->success()
                    ->send();
            })->modalWidth(MaxWidth::Large)->slideOver();
    }

    public function render()
    {

        $activeTemplateData = ID_Template::with('attributes')->select('front', 'back','attribute','id')->where('status', 1)->first();

        $x = json_encode($activeTemplateData);
        // $this->currentTemplate = json_decode($x);
        $this->attributesData = json_decode($x);

        
        // $this->attributesData = json_decode($activeTemplateData->attributes);
        // $attribute = json_decode($activeTemplateData->attribute);
        $director = Director::first();
        return view('livewire.i-d.generate');
    }
}
