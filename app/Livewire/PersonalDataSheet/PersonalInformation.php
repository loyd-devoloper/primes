<?php

namespace App\Livewire\PersonalDataSheet;

use App\Models\User;
use App\Models\Address;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\UserInfo;
use Filament\Forms\Form;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Builder\Block;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Forms\Concerns\InteractsWithForms;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Filament\Actions\Concerns\InteractsWithActions;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;
use Filament\Infolists\Concerns\InteractsWithInfolists;


class PersonalInformation extends Component implements HasForms, HasInfolists, HasActions
{
    use InteractsWithForms;
    use InteractsWithInfolists;
    use InteractsWithActions;


    protected $listeners = [
        'refreshQuestionsComponent' => '$refresh',
    ];
    public $data = [];
    public $same_as_permanent = false;
    public $citizenships = [];
    public $profile;
    public function mount()
    {


              $user_info = UserInfo::with('userProfile')->where('id_number', Auth::user()->id_number)->first();


            $user_address = Address::where('id_number', Auth::user()->id_number)->get();


        $permanent = [];
        $residentials = [];
        foreach ($user_address as $value) {

            if ($value->type == 'PERMANENT') {
                $permanent = $value;
                // dd($value);
                // foreach ($value as $key => $address) {
                //     $permanent[$key] = $address;
                // }
            } else {
                foreach ($value as $key => $address) {
                    $residentials = $value;
                    // $residentials[$key] = $address;
                }
            }
        }

        if ($user_info) {
            $this->form->fill([

                'fname' => $user_info?->fname,
                'lname' => $user_info?->lname,
                'mname' => $user_info?->mname,
                'name_extension' => $user_info->name_extension,
                'birth_date' => !!$user_info->birth_date ? Crypt::decryptString($user_info->birth_date) : null,
                'place_birth' => $user_info->place_birth,
                'citizenship' => $user_info->citizenship,
                'sex' => $user_info->sex,
                'civil_status' => $user_info->civil_status,
                'height' => $user_info->height,
                'weight' => $user_info->weight,
                'blood_type' => $user_info->blood_type,
                'gsis_no' => !!$user_info->gsis_no ? Crypt::decryptString($user_info->gsis_no) : null,
                'pag_ibig_no' => !!$user_info->pag_ibig_no ? Crypt::decryptString($user_info->pag_ibig_no) : null,
                'philhealth_no' => !!$user_info->philhealth_no  ? Crypt::decryptString($user_info->philhealth_no) : null,
                'sss_no' => !!$user_info->sss_no ? Crypt::decryptString($user_info->sss_no) : null,
                'tin_no' => !!$user_info->tin_no ? Crypt::decryptString($user_info->tin_no) : null,
                'agency_employee_no' => !!$user_info->agency_employee_no ?  Crypt::decryptString($user_info->agency_employee_no) : null,
                'telephone_no' => !!$user_info->telephone_no ? Crypt::decryptString($user_info->telephone_no) : null,
                'mobile_no' => !!$user_info->mobile_no  ? Crypt::decryptString($user_info->mobile_no) : null,
                'contact_person_name' => $user_info->contact_person_name,
                'contact_person_address' => !!$user_info->contact_person_address ? Crypt::decryptString($user_info->contact_person_address) : null,
                'contact_person_number' => !!$user_info->contact_person_number ? Crypt::decryptString($user_info->contact_person_number) : null,
                'employee_id' => !!Auth::user()->employee_id ? Crypt::decryptString(Auth::user()->employee_id) : null,

                'house_no' => !!$permanent['house_no'] ? Crypt::decryptString($permanent['house_no']) : null,
                'street' => !!$permanent['street'] ? Crypt::decryptString($permanent['street']) : null,
                'subdivision' => !!$permanent['subdivision'] ? Crypt::decryptString($permanent['subdivision']) : null,
                'brgy' => !!$permanent['brgy'] ? Crypt::decryptString($permanent['brgy']) : null,
                'city' => !!$permanent['city'] ? Crypt::decryptString($permanent['city']) : null,
                'province' => !!$permanent['province'] ? Crypt::decryptString($permanent['province']) : null,
                'zipcode' => !!$permanent['zipcode'] ? Crypt::decryptString($permanent['zipcode']) : null,
                'present_house_no' => !!$residentials['house_no'] ? Crypt::decryptString($residentials['house_no']) : null,
                'present_street' => !!$residentials['street'] ? Crypt::decryptString($residentials['street']) : null,
                'present_subdivision' => !!$residentials['subdivision'] ? Crypt::decryptString($residentials['subdivision']) : null,
                'present_brgy' =>  !!$residentials['brgy'] ? Crypt::decryptString($residentials['brgy']) : null,
                'present_city' => !!$residentials['city'] ? Crypt::decryptString($residentials['city']) : null,
                'present_province' => !!$residentials['province'] ? Crypt::decryptString($residentials['province']) : null,
                'present_zipcode' => !!$residentials['zipcode'] ? Crypt::decryptString($residentials['zipcode']) : null,

                'profile' => $user_info->userProfile->profile
            ]);
        }

        // get citizenship data
        $contents = File::get(public_path("/json/citizenship.json"));
        $array = [];
        foreach (json_decode($contents) as $key => $value) {
            $array[$value] = $value;
        }
        $this->citizenships = $array;
        // default  citizenship value
        $this->data['citizenship'] = 'Filipino';
    }
    public function updating($property, $value)
    {

        if ($property == 'data.same_as_permanent') {
            $this->same_as_permanent = $value;
            if ($value) {

                $this->data['present_house_no'] = isset($this->data['house_no']) ? $this->data['house_no'] : '';
                $this->data['present_street'] =  isset($this->data['street']) ? $this->data['street'] : '';
                $this->data['present_subdivision'] = isset($this->data['subdivision']) ? $this->data['subdivision'] : '';
                $this->data['present_brgy'] =  isset($this->data['brgy']) ? $this->data['brgy'] : '';
                $this->data['present_city'] = isset($this->data['city']) ? $this->data['city'] : '';
                $this->data['present_province'] = isset($this->data['province']) ? $this->data['province'] : '';
                $this->data['present_zipcode'] = isset($this->data['zipcode']) ? $this->data['zipcode'] : '';
            } else {
                $this->data['present_house_no'] = '';
                $this->data['present_street'] = '';
                $this->data['present_subdivision'] = '';
                $this->data['present_brgy'] = '';
                $this->data['present_city'] = '';
                $this->data['present_province'] = '';
                $this->data['present_zipcode'] = '';
            }
        }
    }

    public function form(Form $form): Form
    {
        return $form->schema([

            Section::make('')->schema([
                Grid::make([
                    'default' => 2,
                    'sm' => 2,
                    'md' => 3,
                    'lg' => 4,

                ])->schema([
                    TextInput::make('fname')->label('First name')->required()->autocomplete('on')->autocapitalize('words')->rules('required'),
                    TextInput::make('mname')->label('Middle name'),
                    TextInput::make('lname')->label('Surname')->required()->rules('required'),
                    TextInput::make('name_extension')->label('Extension name')->maxLength('10'),
                    DatePicker::make('birth_date')->label('Date of Birth')->format('m/d/Y'),
                    TextInput::make('place_birth')->label('Place of Birth'),
                    Select::make('sex')
                        ->label('Sex')
                        ->options([
                            'Male' => 'Male',
                            'Female' => 'Female',
                        ]),
                    Select::make('civil_status')
                        ->label('Civil Status')
                        ->options([
                            'Single' => 'Single',
                            'Widowed' => 'Widowed',
                            'Married' => 'Married',
                            'Seperated' => 'Seperated',
                            'Solo Parent' => 'Solo Parent',
                            'Others' => 'Others',
                        ]),
                    Select::make('citizenship')
                        ->label('Citizenship')
                        ->searchable()
                        ->options([
                            'Filipino'=>'Filipino'
                        ]),
                    TextInput::make('mobile_no')->label('Mobile phone')->tel()->mask('09999999999'),

                    TextInput::make('telephone_no')->label('Telephone number')->tel()->mask('09999999999'),
                    TextInput::make('height')->label('Height')->numeric()->suffix('cm'),
                    TextInput::make('weight')->label('Weight')->numeric()->suffix('kg'),
                    TextInput::make('gsis_no')->label('GSIS No.')->label(' GSIS No. '),
                    TextInput::make('pag_ibig_no')->label('Pag Ibig No.')->mask('9999-9999-9999'),
                    TextInput::make('philhealth_no')->label('Philhealth No.')->mask('99-999999999-9'),
                    TextInput::make('sss_no')->label('SSS No.')->mask('99-9999999-9'),
                    TextInput::make('tin_no')->label('TIN No.'),
                    TextInput::make('agency_employee_no')->label('Agency/Employee No.'),
                    Select::make('blood_type')
                        ->label('Blood type')
                        ->options([
                            'A+' => 'A+',
                            'A-' => 'A-',
                            'B+' => 'B+',
                            'B-' => 'B-',
                            'O+' => 'O+',
                            'O-' => 'O-',
                            'AB+' => 'AB+',
                            'AB-' => 'AB-',
                        ]),
                    TextInput::make('employee_id')->label('Employee ID.')->required(),
                ]),
            ]),
            Section::make('Contact Person')
                ->description('( In case of Emergency )')
                ->schema([
                    TextInput::make('contact_person_name')->label('Full name')->required(),
                    TextInput::make('contact_person_address')->label('Address')->required(),
                    TextInput::make('contact_person_number')->label('Contact Number')->required(),
                ])->columns(3),
            Section::make('Permanent Address (required)')

                ->schema([
                    TextInput::make('house_no')->label('House / Block No')->required(),
                    TextInput::make('street')->label('Street')->required(),
                    TextInput::make('subdivision')->label('Subdivision / Village')->required(),
                    TextInput::make('brgy')->label('Barangay')->required(),
                    TextInput::make('city')->label('City / Municipality')->required(),
                    TextInput::make('province')->label('Province')->required(),
                    TextInput::make('zipcode')->label('Zipcode')->required(),
                ])->columns([
                    'default' => 1,
                    'sm' => 2,
                    'md' => 3,
                    'lg' => 4,


                ]),
            Section::make('Present Address (required)')->schema([
                Checkbox::make('same_as_permanent')->label('Same as Pemanent')->statePath('same_as_permanent')
                    ->live(),
                $this->permanentAdd()

            ]),
            Section::make()->schema([
                FileUpload::make('profile')->label(new HtmlString('<span>UPLOAD PROFILE <span class="text-gray-400">(passport size)</span> </span>'))->directory('user/profile')->required()
                    ->image()->imagePreviewHeight('138'),

            ])



        ])->statePath('data');
    }
    public function permanentAdd()
    {
        if ($this->same_as_permanent == false) {
            return  Group::make()
                ->schema([
                    TextInput::make('present_house_no')->label('House / Block No')->required(),
                    TextInput::make('present_street')->label('Street')->required(),
                    TextInput::make('present_subdivision')->label('Subdivision / Village')->required(),
                    TextInput::make('present_brgy')->label('Barangay')->required(),
                    TextInput::make('present_city')->label('City / Municipality')->required(),
                    TextInput::make('present_province')->label('Province')->required(),
                    TextInput::make('present_zipcode')->label('Zipcode')->required(),

                ])->columns([
                    'default' => 1,
                    'sm' => 2,
                    'md' => 3,
                    'lg' => 4,


                ]);
        } else {

            return  Group::make()
                ->schema([
                    TextInput::make('present_house_no')->label('House / Block No')->disabled(),
                    TextInput::make('present_street')->label('Street')->disabled(),
                    TextInput::make('present_subdivision')->label('Subdivision / Village')->disabled(),
                    TextInput::make('present_brgy')->label('Barangay')->disabled(),
                    TextInput::make('present_city')->label('City / Municipality')->disabled(),
                    TextInput::make('present_province')->label('Province')->disabled(),
                    TextInput::make('present_zipcode')->label('Zipcode')->disabled(),

                ])->columns([
                    'default' => 1,
                    'sm' => 2,
                    'md' => 3,
                    'lg' => 4,


                ]);
        }
    }
    public function store()
    {

        $this->validate();
        $permanent = [
            'id_number' => Auth::user()->id_number,
            'house_no' => Crypt::encryptString($this->data['house_no'])  ?? null,
            'street' => Crypt::encryptString($this->data['street']) ?? null,
            'subdivision' => Crypt::encryptString($this->data['subdivision']) ?? null,
            'brgy' => Crypt::encryptString($this->data['brgy']) ?? null,
            'city' => Crypt::encryptString($this->data['city']) ?? null,
            'province' => Crypt::encryptString($this->data['province']) ?? null,
            'zipcode' => Crypt::encryptString($this->data['zipcode']) ?? null,
            'type' => 'PERMANENT',
        ];
        $residentials = [
            'id_number' => Auth::user()->id_number,
            'house_no' => Crypt::encryptString($this->data['present_house_no'])  ?? null,
            'street' => Crypt::encryptString($this->data['present_street']) ?? null,
            'subdivision' => Crypt::encryptString($this->data['present_subdivision']) ?? null,
            'brgy' => Crypt::encryptString($this->data['present_brgy']) ?? null,
            'city' => Crypt::encryptString($this->data['present_city']) ?? null,
            'province' => Crypt::encryptString($this->data['present_province']) ?? null,
            'zipcode' => Crypt::encryptString($this->data['present_zipcode']) ?? null,
            'type' => 'RESIDENTIAL',
        ];
        $userInfoData = [
            'id_number' => Auth::user()->id_number,
            'lname' => !!data_get($this->data, 'lname') ? Crypt::encryptString($this->data['lname']) : null,
            'fname' => !!data_get($this->data, 'fname') ? Crypt::encryptString($this->data['fname']) : null,
            'mname' => !!data_get($this->data, 'mname') ? Crypt::encryptString($this->data['mname']) : null,
            'name_extension' => $this->data['name_extension'] ?? null,
            'birth_date' => !!data_get($this->data, 'birth_date') ? Crypt::encryptString($this->data['birth_date']) : null,
            'place_birth' => $this->data['place_birth'] ?? null,
            'citizenship' => $this->data['citizenship'] ?? null,
            'sex' => $this->data['sex'] ?? null,
            'civil_status' => $this->data['civil_status'] ?? null,
            'height' => $this->data['height'] ?? null,
            'weight' => $this->data['weight'] ?? null,
            'blood_type' => $this->data['blood_type'] ?? null,
            'gsis_no' =>  !!data_get($this->data, 'gsis_no') ? Crypt::encryptString($this->data['gsis_no']) : null,
            'pag_ibig_no' => !!data_get($this->data, 'pag_ibig_no') ? Crypt::encryptString($this->data['pag_ibig_no']) : null,
            'philhealth_no' => !!data_get($this->data, 'philhealth_no') ? Crypt::encryptString($this->data['philhealth_no']) : null,
            'sss_no' => !!data_get($this->data, 'sss_no') ? Crypt::encryptString($this->data['sss_no']) : null,
            'tin_no' => !!data_get($this->data, 'tin_no') ? Crypt::encryptString($this->data['tin_no']) : null,
            'agency_employee_no' => !!data_get($this->data, 'agency_employee_no') ? Crypt::encryptString($this->data['agency_employee_no']) : null,
            'telephone_no' => !!data_get($this->data, 'telephone_no') ? Crypt::encryptString($this->data['telephone_no']) : null,
            'mobile_no' => !!data_get($this->data, 'mobile_no') ? Crypt::encryptString($this->data['mobile_no']) : null,
            'contact_person_name' => $this->data['contact_person_name'],
            'contact_person_address' => !!data_get($this->data, 'contact_person_address') ? Crypt::encryptString($this->data['contact_person_address']) : null,
            'contact_person_number' => !!data_get($this->data, 'contact_person_number') ? Crypt::encryptString($this->data['contact_person_number']) : null,

        ];
        $check = UserInfo::where('id_number', Auth::user()->id_number)->first();
        if ($check) {
            UserInfo::where('id_number', Auth::user()->id_number)->update($userInfoData);
            $user_address = Address::where('id_number', Auth::user()->id_number)->get();

            if (count($user_address) > 0) {

                Address::where('type', 'PERMANENT')->where('id_number', Auth::user()->id_number)->update($permanent);
                if ($this->same_as_permanent) {
                    $permanent['type'] = 'RESIDENTIAL';
                    Address::where('type', 'RESIDENTIAL')->where('id_number', Auth::user()->id_number)->update($permanent);
                } else {

                    Address::where('type', 'RESIDENTIAL')->where('id_number', Auth::user()->id_number)->update($residentials);
                }
            } else {
                if ($this->same_as_permanent) {
                    Address::insert($permanent);
                    $permanent['type'] = 'RESIDENTIAL';
                    Address::insert($permanent);
                } else {
                    Address::insert($permanent);

                    Address::insert($residentials);
                }
            }
        } else {
            $user_info = UserInfo::insert($userInfoData);
            if ($this->same_as_permanent) {
                Address::insert($permanent);
                $permanent['type'] = 'RESIDENTIAL';
                Address::insert($permanent);
            } else {
                Address::insert($permanent);

                Address::insert($residentials);
            }
        }
        $userinfo = User::select('id', 'employee_id', 'profile','name')->where('id', Auth::id())->first();
        $userinfo->update([
            'employee_id' => Crypt::encryptString($this->data['employee_id']),
        ]);
        if (isset($this->form->getState()['profile'])) {


            if ($userinfo) {
                Log::info("PDS: $userinfo?->name UPDATE PERSONAL INFORMATION");
                $userinfo = User::where('id', Auth::id())->update([
                    'profile' => $this->form->getState()['profile']
                ]);
                $this->data['profile'] = '';

                sleep(1);
                Notification::make()
                    ->title('Record Updated successfully')
                    ->success()
                    ->duration(5000)
                    ->send();
                return redirect()->to('/personnel/PersonalInfo');
            }
        }
        Log::info("PDS: $userinfo?->name UPDATE PERSONAL INFORMATION");
        sleep(1);

        Notification::make()
            ->title('Record Updated successfully')
            ->success()
            ->duration(5000)
            ->send();
    }
    #[Title('Personal Information')]
    public function render()
    {
        return view('livewire.personal-data-sheet.personal-information');
    }
}
