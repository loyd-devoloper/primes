<?php

namespace App\Livewire\ID;

use Livewire\Component;
use App\Models\Director;
use Barryvdh\DomPDF\PDF;
use Filament\Forms\Form;
use App\Models\ID_Template;
use App\Models\ID_Attribute;
use Filament\Actions\Action;
use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\URL;
use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Crypt;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Contracts\HasActions;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;

class Template extends Component implements HasForms, HasActions
{
    use InteractsWithForms;

    use InteractsWithActions;

    public $data = [
        'front' => '',
        'back' => '',

    ];

    public $activeTemplate;
    public $currentTemplate = [];
    public $attributes_data = [];
    public $attributesData = [];


    public function mount()
    {


        $id =  ID_Template::select('id', 'status')->where('status', 1)->first();
        $id ? $this->activeTemplate = $id->id : '';


    }
    public function updating($property,$value)
    {
        if($property == 'mountedActionsData.0.template')
        {
            $this->redirect('/personnel/Generatin-ID/template');
        }
    }

    // save template position
    public function save($data)
    {
        ID_Attribute::where('id_template',$this->activeTemplate)->update([
            'attribute'=>$data
        ]);
        Notification::make()
        ->title('Updated successfully')
        ->success()
        ->send();
        $this->redirect('/personnel/Generatin-ID/template');
    }

    // add template function
    public function modalFormAction()
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
                    Toggle::make('firstname_f')->label('First Name')->inline()->live()->default(false),
                    Toggle::make('middlename_f')->label('Middle Name')->inline()->live()->default(false),
                    Toggle::make('lastname_f')->label('Last Name')->inline()->live()->default(true),
                    Toggle::make('fistname_middlename_f')->label('First Name + Middle name')->inline()->live()->default(true),
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
  // change  template
    public function modalSelectAction()
    {
        return  Action::make('modalSelect')
            ->label('Change Template ')
            ->icon('heroicon-o-arrow-path')
            ->modalHeading('Change Template')
            ->slideOver()
            ->form([
                Select::make('template')->label('Template')->options(ID_Template::latest()->get()->pluck('name', 'id'))

            ])
            ->fillForm(fn ($record): array => [
                'template'=>$this->activeTemplate
            ])

            ->action(function (array $data) {

                ID_Template::select('status')->update(['status' => 0]);
                ID_Template::select('id', 'status')->where('id', $data['template'])->update(['status' => 1]);
                $template = ID_Template::where('status', 1)->first();

                sleep(1);
                Notification::make()
                    ->title('Saved successfully')
                    ->success()
                    ->send();
            })->modalWidth(MaxWidth::Large)->color(Color::Emerald);
    }

    // change demplate
    public function modalDirectorAction()
    {
        return  Action::make('modalDirector')
            ->label('Change Director ')
            ->icon('heroicon-o-arrow-path')
            ->fillForm(function(){
                    $director = Director::first();
                    return [
                        'name'=>$director ? $director->name : null ,
                        'position'=>$director ? $director->position : null,
                        'e_sig'=>$director ? $director->e_sig : null,
                    ];
            })
            ->modalHeading('Change Director')
            ->slideOver()
            ->form([
                TextInput::make('name')->label('Complete Name')->required(),
                TextInput::make('position')->label('Position')->required(),
                FileUpload::make('e_sig')->label('Signature')->required()->directory('director/signature/'),

            ])


            ->action(function (array $data) {

                $check = Director::first();
                if($check)
                {
                    $check->update($data);
                }else{
                    Director::create($data);
                }


                sleep(1);
                Notification::make()
                    ->title('Saved successfully')
                    ->success()
                    ->send();
                    $this->redirect('/personnel/Generatin-ID/template');
            })->modalWidth(MaxWidth::Large)->color(Color::Lime);
    }
    #[Title('ID TEMPLATE')]
    public function render()
    {
        $activeTemplateData = ID_Template::with('attributes')->select('front', 'back','attribute','id')->where('status', 1)->first();

        $x = json_encode($activeTemplateData);
        // $this->currentTemplate = json_decode($x);
        $this->attributesData = json_decode($x);


        // $this->attributesData = json_decode($activeTemplateData->attributes);
        // $attribute = json_decode($activeTemplateData->attribute);
        $director = Director::first();
        $image = QrCode::generate(URL::to(route('auth.validate.employee')));
        $base64Image = 'data:image/svg+xml;base64,' . base64_encode($image);
        return view('livewire.i-d.template', compact('activeTemplateData','director','base64Image'));
    }
}
