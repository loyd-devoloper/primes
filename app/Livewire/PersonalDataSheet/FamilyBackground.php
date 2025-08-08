<?php

namespace App\Livewire\PersonalDataSheet;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Children;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\Action;

use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\HtmlString;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;

use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use App\Models\FamilyBackground as FM;

use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
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

class FamilyBackground extends Component implements HasForms,HasTable,HasActions
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;
    public $data = [];
    public $family_info = [];

    // form table
    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Spouse Information')

            ->schema([
                TextInput::make('spouse_fname')->label('First name'),
                TextInput::make('spouse_mname')->label('Middle name'),
                TextInput::make('spouse_lname')->label('Surname'),
                TextInput::make('spouse_extension')->label(' Extension Name ')->maxLength(6),
                TextInput::make('occupation')->label('  Occupation  '),
                TextInput::make('business_name')->label(' Employer / Business Name '),
                TextInput::make('business_address')->label(' Business Address  '),
                TextInput::make('telephone_no')->label('  Telephone No  '),

            ])->columns([
                'default' => 1,
                'sm' => 2,
                'md' => 3,
                'lg' => 4,
            ]),
        Section::make("Father's Information")

            ->schema([
                TextInput::make('father_fname')->label('First name'),
                TextInput::make('father_mname')->label('Middle name'),
                TextInput::make('father_lname')->label('Surname'),
                TextInput::make('father_extension ')->label(' Extension Name ')->maxLength(6),
            ])->columns([
                'default' => 1,
                'sm' => 2,
                'md' => 3,
                'lg' => 4,
            ]),
        Section::make("Mothers's Information")->description(new HtmlString("<span class='text-gray-500 text-xs'>MOTHER'S MAIDEN NAME</span>"))->schema([
            TextInput::make('mother_maiden_name ')->label("  Mother's Maiden Name  ")->hidden(true),
            TextInput::make('mother_fname')->label('First name'),
                TextInput::make('mother_mname')->label('Middle name'),
                TextInput::make('mother_lname')->label('Surname'),
                // TextInput::make('mother_extension')->label(' Extension Name'),
        ])->columns([
            'default' => 1,
            'sm' => 2,
            'md' => 3,
            'lg' => 4,
        ]),
        ])->statePath('data');
    }

    // store family info
    public function storeFamilyInfo()
    {

        // check if family info already exist
        if($this->family_info)
        {
            FM::where('id_number',Auth::user()->id_number)->update([

                'spouse_lname' => Crypt::encryptString($this->data['spouse_lname']) ?? null,
                'spouse_fname' => Crypt::encryptString($this->data['spouse_fname']) ?? null,
                'spouse_mname' => Crypt::encryptString($this->data['spouse_mname']) ?? null,
                'spouse_extension' => $this->data['spouse_extension'] ?? null,
                'occupation' => Crypt::encryptString($this->data['occupation']) ?? null,
                'business_name' => Crypt::encryptString($this->data['business_name']) ?? null,
                'business_address' =>!!data_get($this->data, 'business_address') ? Crypt::encryptString($this->data['business_address']) : null,
                'telephone_no' => !!data_get($this->data, 'telephone_no') ?  Crypt::encryptString($this->data['telephone_no']) : null,
                'father_lname' => Crypt::encryptString($this->data['father_lname']) ?? null,
                'father_fname' =>Crypt::encryptString( $this->data['father_fname']) ?? null,
                'father_mname' =>Crypt::encryptString( $this->data['father_mname']) ?? null,
                'father_extension' => $this->data['father_extension'] ?? null,
                'mother_maiden_name' => Crypt::encryptString($this->data['mother_maiden_name']) ?? null,
                'mother_lname' => Crypt::encryptString($this->data['mother_lname']) ?? null,
                'mother_fname' => Crypt::encryptString($this->data['mother_fname']) ?? null,
                'mother_mname' => Crypt::encryptString($this->data['mother_mname']) ?? null,

            ]);
        }else{
           FM::create([
                'id_number' =>Auth::user()->id_number ,
                'spouse_lname' =>!!data_get($this->data, 'spouse_lname') ? Crypt::encryptString($this->data['spouse_lname']) : null,
                'spouse_fname' =>!!data_get($this->data, 'spouse_fname') ? Crypt::encryptString($this->data['spouse_fname']) : null,
                'spouse_mname' =>!!data_get($this->data, 'spouse_mname') ? Crypt::encryptString($this->data['spouse_mname']) : null,
                'spouse_extension' => $this->data['spouse_extension'] ?? null,
                'occupation' => !!data_get($this->data, 'occupation') ? Crypt::encryptString($this->data['occupation']) : null,
                'business_name' => !!data_get($this->data, 'business_name') ? Crypt::encryptString($this->data['business_name']) : null,
                'business_address' =>!!data_get($this->data, 'business_address') ? Crypt::encryptString($this->data['business_address']) : null,
                'telephone_no' => !!data_get($this->data, 'telephone_no') ?  Crypt::encryptString($this->data['telephone_no']) : null,
                'father_lname' =>  !!data_get($this->data, 'father_lname') ? Crypt::encryptString($this->data['father_lname']) : null,
                'father_fname' => !!data_get($this->data, 'father_fname') ? Crypt::encryptString( $this->data['father_fname']) : null,
                'father_mname' => !!data_get($this->data, 'father_mname') ? Crypt::encryptString( $this->data['father_mname']) : null,
                'father_extension' => $this->data['father_extension'] ?? null,
                'mother_maiden_name' =>  !!data_get($this->data, 'mother_maiden_name') ? Crypt::encryptString($this->data['mother_maiden_name']) : null,
                'mother_lname' =>  !!data_get($this->data, 'mother_lname') ? Crypt::encryptString($this->data['mother_lname']) : null,
                'mother_fname' =>  !!data_get($this->data, 'mother_fname') ? Crypt::encryptString($this->data['mother_fname']) : null,
                'mother_mname' =>  !!data_get($this->data, 'mother_mname') ? Crypt::encryptString($this->data['mother_mname']) : null,

            ]);

        }
        $name = Auth::user()->name;
        Log::info("PDS: $name UPDATE FAMILY BACKGROUND");
        sleep(1);
        Notification::make()
        ->title(' Record Updated succesfully')
        ->success()
        ->duration(5000)
        ->send();
    }

    // children table
    public function table(Table $table): Table
    {



        return $table
            ->query(Children::query()->where('id_number',Auth::user()->id_number))

            ->columns([
                TextColumn::make('child_name')->label('Complete Name')->state(fn($record) => Crypt::decryptString($record->child_name)),
                TextColumn::make('child_birth_date')->label('Birth Date')->state(fn($record) => Crypt::decryptString($record->child_birth_date)),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                DeleteAction::make()->action(function ($record){
                    $name = Auth::user()->name;
                    Log::info("PDS: $name DELETE CHILDREN");
                    $record->delete();
                    sleep(1);
                    Notification::make()
                        ->title('deleted succesfully')
                        ->success()
                        ->duration(5000)
                        ->send();

                })
            ])
            ->bulkActions([
                // ...
            ]);
    }


    // children add button and function
    public function modalFormAction(): Action
    {

        return Action::make('modalForm')
        ->label('Add Children ')
        ->icon('heroicon-o-plus-circle')
        ->form([
            TextInput::make('child_name')->label('Complete Name')->required(),
            DatePicker::make('child_birth_date')->label('Birth Date')->required(),

        ])
        ->action(function (array $data){
            Children::create([
                'id_number'=>Auth::user()->id_number,
                'child_name'=>Crypt::encryptString($data['child_name']),
                'child_birth_date'=>Crypt::encryptString($data['child_birth_date']),
            ]);
            $name = Auth::user()->name;
            Log::info("PDS: $name ADD CHILDREN");
            sleep(1);
            Notification::make()
            ->title('One record added succesfully')
            ->success()
            ->duration(5000)
            ->send();



        } )->modalWidth(MaxWidth::Small);

    }
    #[Title('Family Background')]
    public function render()
    {
        $count = Children::query()->select('id_number')->where('id_number',Auth::user()->id_number)->get()->count();
        $this->family_info =FM::where('id_number',Auth::user()->id_number)->first();
       //fill all input from family table
       if($this->family_info)
       {
        $this->form->fill([

            'spouse_lname' =>!!$this->family_info->spouse_lname ? Crypt::decryptString($this->family_info->spouse_lname) : null,
            'spouse_fname' =>!!$this->family_info->spouse_fname ? Crypt::decryptString($this->family_info->spouse_fname) : null,
            'spouse_mname' =>!!$this->family_info->spouse_mname ? Crypt::decryptString($this->family_info->spouse_mname) : null,
            'spouse_extension' => $this->family_info->spouse_extension ?? null,
            'occupation' =>!!$this->family_info->occupation ? Crypt::decryptString($this->family_info->occupation) : null,
            'business_name' =>!!$this->family_info->business_name ? Crypt::decryptString($this->family_info->business_name) : null,
            'business_address' =>!!$this->family_info->business_address ? Crypt::decryptString($this->family_info->business_address) : null,
            'telephone_no' =>!!$this->family_info->telephone_no ? Crypt::decryptString($this->family_info->telephone_no) : null,
            'father_lname' =>!!$this->family_info->father_lname ? Crypt::decryptString($this->family_info->father_lname) : null,
            'father_fname' =>!!$this->family_info->father_fname ? Crypt::decryptString($this->family_info->father_fname) : null,
            'father_mname' =>!!$this->family_info->father_mname ? Crypt::decryptString($this->family_info->father_mname) : null,
            'father_extension' => $this->family_info->father_extension ?? null,
            'mother_maiden_name' =>!!$this->family_info->mother_maiden_name ? Crypt::decryptString($this->family_info->mother_maiden_name) : null,
            'mother_lname' =>!!$this->family_info->mother_lname ? Crypt::decryptString($this->family_info->mother_lname) : null,
            'mother_fname' =>!!$this->family_info->mother_fname ? Crypt::decryptString($this->family_info->mother_fname) : null,
            'mother_mname' =>!!$this->family_info->mother_mname ? Crypt::decryptString($this->family_info->mother_mname) : null,

        ]);
       }
        return view('livewire.personal-data-sheet.family-background',compact('count'));
    }
}
