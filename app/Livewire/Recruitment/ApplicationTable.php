<?php

namespace App\Livewire\Recruitment;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Livewire;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Support\Str;



use Livewire\Attributes\Url;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;
use App\Enums\RecruitmentLabelEnum;

use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;

use Filament\Tables\Filters\Filter;

use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;

use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;

use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Filters\Indicator;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;

use Filament\Forms\Components\Textarea;

use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Contracts\HasTable;

use Illuminate\Support\Facades\Storage;

use App\Traits\ApplicantFileUploadTrait;

use Filament\Notifications\Notification;

use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;

use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

use App\Traits\RecruitmentAttachmentFunctionTrait;
use Filament\Actions\Concerns\InteractsWithActions;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;

class ApplicationTable extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithActions;
    use RecruitmentAttachmentFunctionTrait;
    use ApplicantFileUploadTrait;
    use \App\Traits\ApplicationTable\BulkActionTrait;
    public $job_title = '';
    public $job_id = '';

    #[Url()]
    public $activeTab = 'all';
    public $allData = null;
    #[Url()]
    public $tableSearch = '';
    #[Url]
    public ?array $tableFilters = null;
    public function mount($job_title, $id)
    {
        $slug = str_replace('_', ' ', $job_title);
        $slug = strtolower($slug);
        $this->job_title = Str::upper($slug);
        $this->job_id = $id;
    }
    public function changeTab($value)
    {
        $this->tableSearch = '';
        $this->resetPage();

        $this->deselectAllTableRecords();
        sleep(1);

        $this->activeTab = $value;
    }

    public function deleteComment(\App\Models\RecruitmentApplicationFileComment $id, $record)
    {
        \App\Models\ApplicantLog::create([
            'activity' => 'Comment Deleted by ' . Auth::user()->name,
            'message' => $id->comment,
            'id_number' => Auth::user()->id_number,
            'applicant_id' => $id->application_id,
            'type' => '2'
        ]);
        $id->delete();
        $this->resetTable();
        Notification::make()
            ->title('Deleted successfully')
            ->success()
            ->send();
    }

    public function table(Table $table): Table
    {
        // QUERY FROM DATABASE
        if ($this->activeTab == 'checkfile') {
            $query = \App\Models\RecruitmetJobApplication::query()->with(['applicantGrades' => function ($q) {
                $q->with('psbInfo');
            }, 'eligibilityInfo', 'activities', 'activitiesEmail', 'batchInfo', 'jobInfo', 'jobOtherInformation'])->where('application_status', 0)->where('job_id', $this->job_id);
        } elseif ($this->activeTab == 'validator') {
            $query = \App\Models\RecruitmetJobApplication::query()->with(['applicantGrades' => function ($q) {
                $q->with('psbInfo');
            }, 'eligibilityInfo', 'activities', 'activitiesEmail', 'batchInfo', 'jobInfo', 'jobOtherInformation'])->where('application_status', 1)->where('job_id', $this->job_id);
        } elseif ($this->activeTab == 'qualified') {
            $query = \App\Models\RecruitmetJobApplication::query()->with(['applicantGrades' => function ($q) {
                $q->with('psbInfo');
            }, 'eligibilityInfo', 'activities', 'activitiesEmail', 'batchInfo', 'jobInfo', 'jobOtherInformation'])->where('application_status', 2)->where('job_id', $this->job_id);
        } elseif ($this->activeTab == 'all') {
            $query = \App\Models\RecruitmetJobApplication::query()->with(['applicantGrades' => function ($q) {
                $q->with('psbInfo');
            }, 'eligibilityInfo', 'activities', 'activitiesEmail', 'batchInfo', 'jobInfo', 'jobOtherInformation'])->where('job_id', $this->job_id);
        } elseif ($this->activeTab == 'notqualified') {
            $query = \App\Models\RecruitmetJobApplication::query()->with(['applicantGrades' => function ($q) {
                $q->with('psbInfo');
            }, 'eligibilityInfo', 'activities', 'activitiesEmail', 'batchInfo', 'jobInfo', 'jobOtherInformation'])->where('application_status', 4)->where('job_id', $this->job_id);
        }
        return $table
            ->query($query)
            ->headerActions([
                Action::make('PSB GRADING')->label('PSB GRADING')->url(route('recruitment.psb_personnel_grading', ['job_id' => $this->job_id, 'job_batch' => !!$this->tableFilters ? $this->tableFilters['batch']['application_code']  : 'ss', 'job_title' => $this->job_title]))
            ])
            ->filters([

                Filter::make('batch')
                    ->form([
                        Select::make('application_code')
                            ->options(\App\Models\RecruitmentJobBatch::where('job_id', $this->job_id)->orderByDesc('id')->get()->pluck('batch_name', 'batch_id')->all())->default(function () {
                                $default = \App\Models\RecruitmentJobBatch::where('job_id', $this->job_id)->where('status', 1)->first();
                                return $default->batch_id;
                            })->searchable(),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['application_code'],
                                fn($query, $date)  => $query->where('batch_id', '=', $date),
                            );
                    })->indicateUsing(function (array $data): ?array {

                        $indicator = [];
                        if (!!$data['application_code']) $indicator[] = Indicator::make('BATCH')
                            ->removable(false);

                        return $indicator;
                    })
            ])
            ->deferFilters()
            ->deferLoading()
            ->columns([
                // APPLICANT CODE START
                TextColumn::make('application_code')
                    ->label('Applicant Code')
                    ->searchable()
                    ->sortable()
                    ->markdown(),
                // APPLICANT CODE END

                // BATCH NAME START
                TextColumn::make('batch_id')
                    ->label('Batch')
                    ->state(fn($record) => $record->batchInfo?->batch_name),
                // BATCH NAME END

                // FULL NAME START
                TextColumn::make('fullname')
                    ->label('Applicant Name')
                    ->searchable(['fname', 'lname', 'mname'])
                    ->sortable(['lname'])
                    ->state(fn($record) => new HtmlString($record?->lname . ',<br> ' . $record?->fname . ' ' . $record?->mname)),
                // FULL NAME END

                // EMAIL START
                TextColumn::make('email')
                    ->label('Applicant Email')
                    ->searchable()
                    ->copyable()
                    ->state(fn($record) => $record?->email)
                    ->copyMessage('Email address copied')->toggleable(isToggledHiddenByDefault: false),
                // EMAIL END

                // MOBILE NUMBER START
                TextColumn::make('mobile_number')
                    ->label('Applicant Mobile Number')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->state(fn($record) => $record?->mobile_number),
                // MOBILE NUMBER END

                // ADDDRESS START
                TextColumn::make('address')
                    ->label('Applicant Address')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->state(fn($record) => $record?->address)
                    ->extraAttributes(['class' => ' break-all break-words  w-[2rem] overflow-hidden'])
                    ->wrap(),
                // ADDRESS END

                // SUBMITTED START
                TextColumn::make('created_at')
                    ->label('submitted At')
                    ->state(fn($record) => Carbon::parse($record->created_at)
                        ->format('M d, Y h:i:s A'))
                    ->toggleable(isToggledHiddenByDefault: false),
                // SUBMITTED END

                // LAHAT NG EMAIL NA NASEND SA APPLICANT START
                TextColumn::make('activitiesEmail.message')
                    ->label('Emails')
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->badge()
                    ->icon('heroicon-m-check-circle'),
                // LAHAT NG EMAIL NA NASEND SA APPLICANT END

                // STATUS OF APPLICATION START
                TextColumn::make('application_status')->label('Applicant Status')->state(function ($record) {
                    return match ($record->application_status) {
                        0 => \App\Enums\RecruitmemtApplicantStatusEnum::PENDING,
                        1 => \App\Enums\RecruitmemtApplicantStatusEnum::VALIDATE,
                        2 => \App\Enums\RecruitmemtApplicantStatusEnum::QUALIFIED,
                        4 => \App\Enums\RecruitmemtApplicantStatusEnum::NOT_QUALIFIED,
                    };
                })->badge()->color(function ($record) {
                    return match ($record->application_status) {
                        0 => Color::Yellow,
                        1 => Color::Blue,
                        2 => Color::Green,
                        4 => Color::Red,
                    };
                }),
                // STATUS OF APPLICATION END



            ])
            ->actions([
                ActionGroup::make([
                    // ######################################### validate action ##########################################
                    Action::make('Validate')
                        ->modalHeading(function ($record) {
                            return new HtmlString("<h1 class='text-black dark:text-white'> $record->fname $record->lname</h1> <h1 class='text-black dark:text-white'>$record->email</h1>");
                        })
                        ->extraModalActions($this->extraActionsInApplicationTable())
                        ->color(Color::Blue)->icon('heroicon-o-eye')->hidden(fn($record) => $record->application_status == 1 ? false : true)
                        ->form(function ($record) {
                            return $this->allApplicantAttachment($record);
                        })->modalSubmitAction(false)->modalCancelAction(false)
                        ->closeModalByClickingAway(false)->extraAttributes([
                            'id' => 'edit-xx'
                        ])->modalWidth(MaxWidth::ScreenLarge),

                    // ########################################### Check File Action #######################################
                    Action::make('Check File')
                        ->modalHeading(function ($record) {
                            return new HtmlString("<h1 class='text-black dark:text-white'> $record->fname $record->lname</h1> <h1 class='text-black dark:text-white'>$record->email</h1>");
                        })
                        ->extraModalActions([

                            Action::make('extraButton')
                                ->label('Approved and proceed to validator')
                                ->color(Color::Green)
                                ->action(function ($record, $action) {
                                    \App\Models\ApplicantLog::create([
                                        'activity' => 'Approved(Check Requirements) by ' . Auth::user()->name,
                                        'message' => "Pending => Validate",
                                        'id_number' => Auth::user()->id_number,
                                        'applicant_id' => $record->id,
                                        'type' => '1'
                                    ]);
                                    $record->update([
                                        'application_status' => 1
                                    ]);
                                    Notification::make()
                                        ->title('Transfer Data successfully')
                                        ->success()
                                        ->send();
                                    sleep(1);
                                    return redirect()->route('recruitment.application.table', ['job_title' => $this->job_title, 'id' => $this->job_id, 'activeTab' => $this->activeTab, 'tableFilters' => $this->tableFilters]);
                                })->disabled(fn($record) => $record->movs_status != 0 && $record->letter_of_intent_status != 0 && $record->pds_status != 0  && $record->prc_status != 0 && $record->tor_status != 0 && $record->training_attended_status != 0 && $record->certificate_of_employment_status != 0 && $record->latest_appointment_status != 0 && $record->performance_rating_status != 0 && $record->cav_status != 0   ? false  : true),

                        ])
                        ->color(Color::Yellow)->icon('heroicon-o-eye')->hidden(fn($record) => $record->application_status == 0 ? false : true)
                        ->form(function ($record) {
                            return $this->allApplicantAttachment($record);
                        })
                        ->modalSubmitAction(false)->modalCancelAction(false)
                        ->closeModalByClickingAway(false)->extraAttributes([
                            'id' => 'edit-xx'
                        ])->modalWidth(MaxWidth::ScreenLarge),
                    // ######################################### View  action ##########################################
                    Action::make('View')
                        ->modalHeading(function ($record) {
                            return new HtmlString("<h1 class='text-black dark:text-white'> $record->fname $record->lname</h1> <h1 class='text-black dark:text-white'>$record->email</h1>");
                        })
                        ->color(Color::Blue)->icon('heroicon-o-eye')
                        ->hidden(fn($record) => $record->application_status == 2 || $record->application_status == 4 ? false : true)
                        ->form(function ($record) {
                            return $this->allApplicantAttachment($record);
                        })
                        ->modalSubmitAction(false)
                        ->modalCancelAction(false)
                        ->closeModalByClickingAway(false)
                        ->extraAttributes([
                            'id' => 'edit-xx'
                        ])
                        ->modalWidth(MaxWidth::ScreenLarge),
                    // ####################################### Update information #################################################
                    EditAction::make('Updates')
                        ->modalHeading(fn($record): string => "Edit Applicant Information ($record->fname $record->lname)")
                        ->label('Update Information')
                        ->mutateRecordDataUsing(function ($data, $record) {

                            $check = \App\Models\RecruitmentApplicationEligibility::where('application_code', $record->application_code)->first();
                            if ($check) {
                                $data['education'] = json_decode($check->education, true);
                                $data['training'] = json_decode($check->training, true);
                                $data['experience'] = json_decode($check->experience, true);
                                $data['eligibility'] = json_decode($check->eligibility, true);
                            } else {
                                $data['education'] = [''];
                                $data['training'] = [''];
                                $data['experience'] = [''];
                                $data['eligibility'] = [''];
                            }
                            $data['education_status'] = $check?->education_status;
                            $data['education_remarks'] = $check?->education_remarks;
                            $data['training_status'] = $check?->training_status;
                            $data['training_remarks'] = $check?->training_remarks;
                            $data['experience_status'] = $check?->experience_status;
                            $data['experience_remarks'] = $check?->experience_remarks;
                            $data['eligibility_status'] = $check?->eligibility_status;
                            $data['eligibility_remarks'] = $check?->eligibility_remarks;


                            return $data;
                        })
                        ->form([

                            Grid::make([
                                'default' => 1,
                                'sm' => 1,
                                'md' => 2
                            ])->schema([
                                Group::make([
                                    Select::make('select')->label('Select Attachment')->options(function () {
                                        $allCases = RecruitmentLabelEnum::cases();
                                        $exceptOneCases = array_filter($allCases, fn($case) => $case !== RecruitmentLabelEnum::MOVS);
                                        $x = [];
                                        foreach ($exceptOneCases as $exceptOneCase) {
                                            $x[$exceptOneCase->value] = $exceptOneCase->value;
                                        }
                                        return $x;
                                    })->live(),
                                    Hidden::make('token')->reactive(),
                                    PdfViewerField::make('file')
                                        ->label(fn(Get $get) => !!$get('select') ? $get('select') : '')
                                        ->fileUrl(function (Get $get, $record, Set $set) {
                                            $set('token', true);
                                            if (!!$get('select')) {
                                                $value = \App\Enums\RecruitmentLabelEnum::tryFrom($get('select'))?->getColumn();
                                                if (!!$record->$value) {
                                                    $set('token', false);
                                                    $batchinfo = $record->batchInfo->id;
                                                    $jobInfo = $record->jobInfo->id;

                                                    return Storage::url("public/recruitment/application/$jobInfo/$batchinfo/$record->email/" . $record->$value);
                                                }
                                                $set('token', true);
                                                return "";
                                            }
                                            $set('token', true);
                                            return "";
                                        })->minHeight('70svh'),

                                    Placeholder::make('no attachment')->extraAttributes(['class' => 'text-red-500'])->hidden(fn(Get $get) => !!$get('token') ? false : true)

                                ]),
                                // ViewField::make('attachment')->view('livewire.recruitment.assets.attachments'),
                                Group::make([
                                    Fieldset::make('Educations')
                                        ->schema([

                                            Repeater::make('education')
                                                ->label(false)
                                                ->simple(
                                                    Textarea::make('education')->required()

                                                )
                                                ->defaultItems(3)->columnSpan(fn(Get $get) => !!$get('education') ? 3 : 5),
                                            Textarea::make('education_remarks')->hidden(fn(Get $get) => !!$get('education') ? false : true),
                                            Select::make('education_status')->options([
                                                2 =>  \App\Enums\RecruitmemtApplicantStatusEnum::QUALIFIED->value,
                                                4 =>  \App\Enums\RecruitmemtApplicantStatusEnum::NOT_QUALIFIED->value,
                                            ])->default(2)->required()->hidden(fn(Get $get) => !!$get('education') ? false : true),
                                        ])->columns(5)->disabled(fn($record) => $record->application_status == 2 || $record->application_status == 4 ? true : false),
                                    Fieldset::make('Training')
                                        ->schema([
                                            Repeater::make('training')
                                                ->label(false)
                                                ->schema([
                                                    Textarea::make('title')->required()->columnSpan(2),
                                                    Textarea::make('hours')->required()->columnSpan(2),

                                                ])
                                                ->columnSpan(fn(Get $get) => !!$get('training') ? 4 : 7)->columns(4)->defaultItems(3),
                                            Textarea::make('training_remarks')->columnSpan(2)->hidden(fn(Get $get) => !!$get('training') ? false : true),
                                            Select::make('training_status')->options([
                                                2 =>  \App\Enums\RecruitmemtApplicantStatusEnum::QUALIFIED->value,
                                                4 =>  \App\Enums\RecruitmemtApplicantStatusEnum::NOT_QUALIFIED->value,
                                            ])->default(2)->required()->hidden(fn(Get $get) => !!$get('training') ? false : true)

                                        ])->columns(7)->disabled(fn($record) => $record->application_status == 2 || $record->application_status == 4 ? true : false),
                                    Fieldset::make('Experience')
                                        ->schema([
                                            Repeater::make('experience')
                                                ->label(false)
                                                ->schema([
                                                    Textarea::make('details')->required()->columnSpan(2),
                                                    Textarea::make('years')->required()->columnSpan(2),
                                                ])
                                                ->columnSpan(fn(Get $get) => !!$get('experience') ? 4 : 7)->columns(4)->collapsible()->defaultItems(1),
                                            Textarea::make('experience_remarks')->columnSpan(2)->hidden(fn(Get $get) => !!$get('experience') ? false : true),
                                            Select::make('experience_status')->options([
                                                2 =>  \App\Enums\RecruitmemtApplicantStatusEnum::QUALIFIED->value,
                                                4 =>  \App\Enums\RecruitmemtApplicantStatusEnum::NOT_QUALIFIED->value,
                                            ])->default(2)->required()->hidden(fn(Get $get) => !!$get('experience') ? false : true)
                                        ])->columns(7)->disabled(fn($record) => $record->application_status == 2 || $record->application_status == 4 ? true : false),
                                    Fieldset::make('Eligibility')
                                        ->schema([
                                            Repeater::make('eligibility')
                                                ->label(false)
                                                ->simple(
                                                    Textarea::make('title')->required(),
                                                )
                                                ->defaultItems(1)->columnSpan(fn(Get $get) => !!$get('eligibility') ? 3 : 5),
                                            Textarea::make('eligibility_remarks')->hidden(fn(Get $get) => !!$get('eligibility') ? false : true),
                                            Select::make('eligibility_status')->options([
                                                2 =>  \App\Enums\RecruitmemtApplicantStatusEnum::QUALIFIED->value,
                                                4 =>  \App\Enums\RecruitmemtApplicantStatusEnum::NOT_QUALIFIED->value,
                                            ])->default(2)->required()->hidden(fn(Get $get) => !!$get('eligibility') ? false : true),
                                        ])->columns(5)->disabled(fn($record) => $record->application_status == 2 || $record->application_status == 4 ? true : false),
                                ])->extraAttributes(['class' => 'border-2 p-5 bg-gray-100 dark:bg-transparent']),

                            ])


                        ])
                        ->action(function ($data, $record) {

                            $education = json_encode($data['education']);

                            $training = json_encode($data['training']);
                            $experience = json_encode($data['experience']);
                            $eligibility = json_encode($data['eligibility']);
                            $check = \App\Models\RecruitmentApplicationEligibility::where('application_code', $record->application_code)->first();
                            $data = [
                                'application_code' => $record->application_code,
                                'education' => $education,
                                'education_status' => !!data_get($data, 'education_status') ? $data['education_status'] : null,
                                'education_remarks' => !!data_get($data, 'education_remarks') ? $data['education_remarks'] : null,
                                'training_status' => !!data_get($data, 'training_status') ? $data['training_status'] : null,
                                'training_remarks' => !!data_get($data, 'training_remarks') ? $data['training_remarks'] : null,
                                'experience_status' => !!data_get($data, 'experience_status') ? $data['experience_status'] : null,
                                'experience_remarks' => !!data_get($data, 'experience_remarks') ? $data['experience_remarks'] : null,
                                'eligibility_status' => !!data_get($data, 'eligibility_status') ? $data['eligibility_status'] : null,
                                'eligibility_remarks' => !!data_get($data, 'eligibility_remarks') ? $data['eligibility_remarks'] : null,
                                'training' => $training,
                                'experience' => $experience,
                                'eligibility' =>  $eligibility,
                            ];
                            if ($check) {
                                $check->update($data);
                            } else {
                                \App\Models\RecruitmentApplicationEligibility::create($data);
                            }
                            $finalMessage = implode(',<br> ', array_map(function ($k, $v) {
                                return "$k: $v";
                            }, array_keys($data), $data));
                            \App\Models\ApplicantLog::create([
                                'activity' => 'Updated by ' . Auth::user()->name . '(UPDATE INFORMATION)',
                                'message' => new htmlString("<main class='text-gray-500 dark:text-gray-400'>
                                    $finalMessage
                                <br></main>
                                "),
                                'id_number' => Auth::user()->id_number,
                                'applicant_id' => $record->id,
                                'type' => '1'
                            ]);

                            Notification::make()
                                ->title('Updated successfully')
                                ->success()
                                ->send();
                        })
                        ->hidden(function(){
                            if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value)) return false;
                            if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value)) return true;

                        })
                        ->modalWidth(MaxWidth::Full)->color(Color::Green)
                        ->hidden(fn($record) => $record->application_status == 1 || $record->application_status == 2 || $record->application_status == 4 ? false : true),
                    // ####################################### Activity log Action #################################################
                    Action::make('logs')
                        ->label('Activity Logs')
                        ->icon('heroicon-o-clock')
                        ->modalContent(function ($record) {
                            // $logs = \App\Models\ApplicantLog::with('employeeInfo')->where('applicant_id', $record->id)->orderByDesc('id')->get();
                            $logs = $record->activities;
                            return view('livewire.recruitment.activity_log', compact('logs'));
                        })
                        ->modalSubmitAction(false)
                        ->modalCancelAction(false)
                        ->color(Color::Gray)->modalWidth(MaxWidth::ScreenExtraLarge),

                    // ####################################### APPLICANT IES #################################################
                    Action::make('ies')
                        ->label('Applicant IES FILE')
                        ->extraModalActions([

                            EditAction::make('statusx')
                                ->icon('heroicon-o-arrow-up-tray')
                                ->modalHeading('Upload File')
                                ->color(Color::Amber)
                                ->label('Upload File')
                                ->form([

                                    FileUpload::make('ies_file')
                                        ->directory('recruitment/application/ies')->acceptedFileTypes(['application/pdf'])->preserveFilenames()->getUploadedFileNameForStorageUsing(
                                            fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                                ->prepend(time() . '-/-'),
                                        )
                                ])
                                ->modalWidth(MaxWidth::Small)
                                ->modalSubmitActionLabel('Upload')
                                ->action(function ($data, $record) {

                                    $record->update([
                                        'ies_file'=>$data['ies_file']
                                    ]);
                                    Notification::make()
                                        ->title('Uploaded Successfully')
                                        ->success()
                                        ->send();
                                }),

                        ])
                        ->hidden(function(){
                            if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value)) return false;
                            if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value)) return true;

                        })
                        ->icon('heroicon-o-arrow-up-tray')
                        ->modalHeading(fn($record) => "$record->fname $record->mname $record->lname")
                        ->form([
                            PdfViewerField::make('IES WITH SIGNED')
                            ->label('IES WITH SIGN')
                                   ->minHeight('70svh')
                                   ->fileUrl(function ($record){



                                        return Storage::url("public/$record->ies_file");

                                   })->hidden(fn($record): bool => !!$record->ies_file ? false : true),
                        ])->modalSubmitAction(false)->modalCancelAction(false),
                ])->extraAttributes(['title' => 'Action button'])
            ])
            ->bulkActions($this->bulkAction())
            ->checkIfRecordIsSelectableUsing(function ($record) {

                // CHECK IF APPLICANT AY MERON NG EDUCATION,TRAINING,EXPERIENCE,ELIGIBILITY DATA PAG WALA PA NAKA DISABLE LANG YUNG CHECKBOX
                if ($this->activeTab != 'validator') {
                    return true;
                } else {
                    return !!$record->eligibilityInfo  ? true : false;
                }
            })
            ->recordClasses(function ( $record){
               return $record->batchInfo?->hired_applicant_id == $record?->application_code ? 'hired' : null;

            })
            ->paginationPageOptions(['1', '5', '10', '20', '30', 'all'])
            ->striped()->defaultSort('created_at', 'desc');
    }



    public function render()
    {



        if (!!$this->tableFilters['batch']) {
            if (!!$this->tableFilters['batch']['application_code']) {

                $checkFileCount = \App\Models\RecruitmetJobApplication::query()->where('application_status', 0)->where('batch_id', $this->tableFilters['batch']['application_code'])->where('job_id', $this->job_id)->get()->count();
                $validatorCount = \App\Models\RecruitmetJobApplication::query()->where('application_status', 1)->where('batch_id', $this->tableFilters['batch']['application_code'])->where('job_id', $this->job_id)->get()->count();
                $qualifiedCount = \App\Models\RecruitmetJobApplication::query()->where('application_status', 2)->where('batch_id', $this->tableFilters['batch']['application_code'])->where('job_id', $this->job_id)->get()->count();
                $notqualifiedCount = \App\Models\RecruitmetJobApplication::query()->where('application_status', 4)->where('batch_id', $this->tableFilters['batch']['application_code'])->where('job_id', $this->job_id)->get()->count();
                $allCount = \App\Models\RecruitmetJobApplication::query()->where('job_id', $this->job_id)->where('batch_id', $this->tableFilters['batch']['application_code'])->get()->count();
            } else {
                $checkFileCount = \App\Models\RecruitmetJobApplication::query()->where('application_status', 0)->where('job_id', $this->job_id)->get()->count();
                $validatorCount = \App\Models\RecruitmetJobApplication::query()->where('application_status', 1)->where('job_id', $this->job_id)->get()->count();
                $qualifiedCount = \App\Models\RecruitmetJobApplication::query()->where('application_status', 2)->where('job_id', $this->job_id)->get()->count();
                $notqualifiedCount = \App\Models\RecruitmetJobApplication::query()->where('application_status', 4)->where('job_id', $this->job_id)->get()->count();
                $allCount = \App\Models\RecruitmetJobApplication::query()->where('job_id', $this->job_id)->get()->count();
            }
        }

        return view('livewire.recruitment.application-table', compact('checkFileCount', 'validatorCount', 'qualifiedCount', 'allCount', 'notqualifiedCount'))->title($this->job_title);
    }
}
