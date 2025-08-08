<?php

namespace App\Livewire\ID;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Children;
use App\Models\Director;
use App\Models\UserInfo;
use Filament\Tables\Table;
use App\Models\ID_Template;

use Illuminate\Support\Str;
use App\Livewire\ID\Template;


use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\URL;
use Filament\Support\Enums\MaxWidth;

use Illuminate\Support\Facades\Crypt;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Grid;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;

use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Contracts\HasActions;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Actions\Concerns\InteractsWithActions;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class Dashboard extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;

    public $activeTemplate;
    public $currentTemplate = [];
    public $attributes_data = [];
    public $attributesData = [];
    public $director = [];

    public function mount()
    {


        $id =  ID_Template::select('id', 'status')->where('status', 1)->first();
        $id ? $this->activeTemplate = $id->id : '';
        $this->director = Director::first();
    }

    public function table(Table $table): Table
    {


        return $table
            ->query(User::query()->select('id', 'name', 'id_number', 'employee_id', 'fd_code')->withCount(['idLogs'])->with(['user_fd_code']))
            ->headerActions([
                Action::make('addtemplate')->label('Change Template')->icon('heroicon-o-arrow-path')->button()->url(fn() => route('id.template'))->color(Color::Green)
            ])
            ->columns([
                TextColumn::make('name')->label('Full Name')->searchable(),

                TextColumn::make('x')->label('Unit/Division')->state(function ($record) {

                    return $record->user_fd_code?->division_name;
                }),
                TextColumn::make('id_logs_count')->label('No. of Generate'),
            ])
            ->actions([
                ViewAction::make('Logs')
                    ->label('Logs')
                    ->icon('heroicon-o-clock')
                    ->extraModalActions([
                        EditAction::make('statusx')
                            ->icon('heroicon-o-arrow-up-tray')
                            ->modalHeading('Upload File')
                            ->color(Color::Amber)
                            ->label('Upload File')
                            ->form(function ($record) {
                                $form = [
                                    FileUpload::make('file')
                                        ->directory('id/logs')->required()->image()->preserveFilenames()->getUploadedFileNameForStorageUsing(
                                            fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                                ->prepend($record->name . '/'.rand(100000, 999999).'.'),
                                        )
                                ];
                                return $form;
                            })
                            ->modalWidth(MaxWidth::Small)
                            ->modalSubmitActionLabel('Upload')
                            ->action(function ($data, $record)  {

                                \App\Models\ID_Log::create([
                                    'id_number' => $record->id_number,
                                    'photo' => $data['file'],
                                ]);

                                Notification::make()
                                    ->title('Uploaded Successfully')
                                    ->success()
                                    ->send();

                            }),

                    ])
                    ->modalHeading('Employee ID Logs')
                    ->color(Color::Gray)
                    ->infolist(function ($record) {
                        $employeeLog = \App\Models\ID_Log::where('id_number',$record->id_number)->orderByDesc('id')->get();
                        $logs = [];
                        foreach ($employeeLog as $log) {
                            $logs[] =    ImageEntry::make('Photo')->defaultImageUrl(url("storage/$log->photo"))->extraImgAttributes([
                                'alt' => 'Logo',
                                'loading' => 'lazy',
                            ]);
                            $logs[] = TextEntry::make('Created at')->default(Carbon::parse($log->created_at)->format('F d, Y h:i:s A'));
                        }
                        $x = [
                            Grid::make([
                                'default' => 1,
                                'sm' => 2,

                            ])->schema($logs)->extraAttributes(['class' => 'viewLogId'])
                        ];
                        return $x;
                    }),
                Action::make('GENERATE')->label('Generate')->icon('heroicon-o-inbox-arrow-down')
                    ->modalContent(function ($record) {
                        $image = QrCode::generate(URL::to(route('auth.validate.employee')) . '?q=' . Crypt::encryptString($record->employee_id));
                        $base64Image = 'data:image/svg+xml;base64,' . base64_encode($image);

                        $userData = User::query()
                            ->with(['userInfo' => function ($q) {
                                return $q->select('id_number', 'fname', 'mname', 'lname', 'contact_person_name', 'contact_person_number');
                            }, 'workExperiencefirst' => function ($ex) {
                                return $ex->select('id_number', 'status', 'position_title', 'to')->where('status', 'active')->where('to', 'PRESENT');
                            }, 'user_fd_code', 'otherInfo'])->where('id', $record->id)->first();


                        $activeTemplateData = ID_Template::with('attributes')->select('front', 'back', 'attribute', 'id')->where('status', 1)->first();

                        $x = json_encode($activeTemplateData);
                        // $this->currentTemplate = json_decode($x);
                        $attributesData = json_decode($x);


                        // $this->attributesData = json_decode($activeTemplateData->attributes);
                        // $attribute = json_decode($activeTemplateData->attribute);
                        $director = $this->director;
                        $activeTemplate = $this->activeTemplate;

                        return view('livewire.i-d.generate', compact('record', 'activeTemplateData', 'activeTemplate', 'director', 'attributesData', 'userData', 'base64Image'));
                    })
                    ->modalSubmitAction(false)->disabledForm()->slideOver()
            ])->paginationPageOptions(['5', '10', '20', '50']);
    }


    #[Title('Generating ID')]
    public function render()
    {





        return view('livewire.i-d.dashboard');
    }
}
